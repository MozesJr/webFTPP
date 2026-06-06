<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TerminalController extends Controller
{
    private const ALLOWED_EMAIL = 'superadmin@faculty.ac.id';

    // Versi PHP CLI yang dipakai web server (PHP 8.3)
    private const PHP_BIN = '/usr/bin/php8.3';

    // Perintah yang diblokir keras untuk menghindari kerusakan sistem
    private const BLOCKED_PATTERNS = [
        '/\brm\s+-rf\s+\//',           // rm -rf /
        '/\bmkfs\b/',                   // format disk
        '/\bdd\s+.*of=\/dev/',          // tulis ke raw device
        '/\bshutdown\b/',               // matikan server
        '/\breboot\b/',                 // restart server
        '/\bhalt\b/',                   // hentikan sistem
        '/\bpoweroff\b/',               // matikan daya
        '/:\(\)\{\s*:\|:&\s*\};:/',    // fork bomb
        '/\bchmod\s+777\s+\//',        // chmod 777 root
        '/\bchown\s+.*\s+\/\s/',       // chown pada root
    ];

    // Urutan perintah untuk fitur auto-deploy
    private const DEPLOY_COMMANDS = [
        'git pull origin main',
        self::PHP_BIN . ' artisan migrate --force',
        self::PHP_BIN . ' artisan config:cache',
        self::PHP_BIN . ' artisan route:cache',
    ];

    public function index(Request $request)
    {
        $this->authorizeEmail($request);

        return Inertia::render('SuperAdmin/Terminal', [
            'user' => $request->user()->only('name', 'email'),
        ]);
    }

    public function stream(Request $request): StreamedResponse
    {
        $this->authorizeEmail($request);

        $raw = trim($request->input('command', ''));

        if (empty($raw)) {
            return $this->streamError('Perintah tidak boleh kosong.');
        }

        // Ganti binary 'php ' di awal perintah dengan path versi yang benar
        $command = $this->resolvePhpBin($raw);

        if ($this->isBlocked($command)) {
            return $this->streamError('Perintah diblokir karena berpotensi merusak sistem.');
        }

        return $this->streamCommand($command);
    }

    public function deploy(Request $request): StreamedResponse
    {
        $this->authorizeEmail($request);

        return response()->stream(function () {
            if (ob_get_level()) {
                ob_end_clean();
            }

            echo "data: " . json_encode([
                'type'    => 'deploy_start',
                'message' => 'Memulai proses deploy — ' . count(self::DEPLOY_COMMANDS) . ' perintah akan dijalankan.',
            ]) . "\n\n";
            flush();

            foreach (self::DEPLOY_COMMANDS as $index => $command) {
                $step = $index + 1;

                echo "data: " . json_encode([
                    'type'    => 'step',
                    'step'    => $step,
                    'total'   => count(self::DEPLOY_COMMANDS),
                    'command' => $command,
                ]) . "\n\n";
                flush();

                $failed = false;

                $result = Process::timeout(120)
                    ->path(base_path())
                    ->run($command, function (string $type, string $chunk) {
                        foreach (explode("\n", $chunk) as $line) {
                            echo "data: " . json_encode(['type' => 'output', 'line' => $line]) . "\n\n";
                            flush();
                        }
                    });

                echo "data: " . json_encode([
                    'type'      => 'step_done',
                    'step'      => $step,
                    'exit_code' => $result->exitCode(),
                    'success'   => $result->successful(),
                ]) . "\n\n";
                flush();

                // Hentikan rangkaian jika salah satu langkah gagal
                if (!$result->successful()) {
                    echo "data: " . json_encode([
                        'type'    => 'deploy_failed',
                        'message' => "Deploy berhenti pada langkah {$step}: {$command} (exit {$result->exitCode()})",
                    ]) . "\n\n";
                    flush();
                    $failed = true;
                    break;
                }
            }

            if (!isset($failed) || !$failed) {
                echo "data: " . json_encode([
                    'type'    => 'deploy_success',
                    'message' => 'Deploy selesai — semua langkah berhasil.',
                ]) . "\n\n";
                flush();
            }

            echo "data: [DONE]\n\n";
            flush();

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ]);
    }

    // ── Private helpers ────────────────────────────────────────────────────

    private function streamCommand(string $command): StreamedResponse
    {
        return response()->stream(function () use ($command) {
            if (ob_get_level()) {
                ob_end_clean();
            }

            echo "data: " . json_encode(['type' => 'start', 'command' => $command]) . "\n\n";
            flush();

            try {
                $result = Process::timeout(60)
                    ->path(base_path())
                    ->run($command, function (string $type, string $chunk) {
                        foreach (explode("\n", $chunk) as $line) {
                            echo "data: " . json_encode(['type' => 'output', 'line' => $line]) . "\n\n";
                            flush();
                        }
                    });

                echo "data: " . json_encode([
                    'type'      => 'done',
                    'exit_code' => $result->exitCode(),
                    'success'   => $result->successful(),
                ]) . "\n\n";
                flush();

            } catch (\Throwable $e) {
                echo "data: " . json_encode([
                    'type'    => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";
                flush();
            }

            echo "data: [DONE]\n\n";
            flush();

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ]);
    }

    /**
     * Ganti 'php ' di awal perintah dengan binary PHP yang benar.
     * Menangani: "php ...", "php8.0 ...", "php8.2 ..." → self::PHP_BIN
     */
    private function resolvePhpBin(string $command): string
    {
        return preg_replace(
            '/^php(?:\d+\.\d+)?\s+/',
            self::PHP_BIN . ' ',
            $command
        );
    }

    private function authorizeEmail(Request $request): void
    {
        if ($request->user() === null || $request->user()->email !== self::ALLOWED_EMAIL) {
            abort(403, 'Akses ditolak. Fitur ini hanya tersedia untuk superadmin.');
        }
    }

    private function isBlocked(string $command): bool
    {
        foreach (self::BLOCKED_PATTERNS as $pattern) {
            if (preg_match($pattern, $command)) {
                return true;
            }
        }
        return false;
    }

    private function streamError(string $message): StreamedResponse
    {
        return response()->stream(function () use ($message) {
            echo "data: " . json_encode(['type' => 'error', 'message' => $message]) . "\n\n";
            echo "data: [DONE]\n\n";
            flush();
        }, 200, [
            'Content-Type'  => 'text/event-stream',
            'Cache-Control' => 'no-cache',
        ]);
    }
}
