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

    // Perintah yang diblokir keras untuk menghindari kerusakan sistem
    private const BLOCKED_PATTERNS = [
        '/\brm\s+-rf\s+\//',           // rm -rf /
        '/\bmkfs\b/',                   // format disk
        '/\bdd\s+.*of=\/dev/',          // tulis ke raw device
        '/\bshutdown\b/',               // matikan server
        '/\breboot\b/',                 // restart server
        '/\bhalt\b/',                   // hentikan sistem
        '/\bpoweroff\b/',              // matikan daya
        '/:\(\)\{\s*:\|:&\s*\};:/',    // fork bomb
        '/\bchmod\s+777\s+\//',        // chmod 777 root
        '/\bchown\s+.*\s+\/\s/',       // chown pada root
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

        $command = trim($request->input('command', ''));

        if (empty($command)) {
            return $this->streamError('Perintah tidak boleh kosong.');
        }

        if ($this->isBlocked($command)) {
            return $this->streamError('Perintah diblokir karena berpotensi merusak sistem.');
        }

        return response()->stream(function () use ($command) {
            // Header SSE sudah di-set via headers(), flush buffer awal
            if (ob_get_level()) {
                ob_end_clean();
            }

            echo "data: " . json_encode(['type' => 'start', 'command' => $command]) . "\n\n";
            flush();

            try {
                $process = Process::timeout(60)
                    ->path(base_path())
                    ->start($command);

                // Stream output baris per baris secara real-time
                foreach ($process->output() as $chunk) {
                    // Satu chunk bisa mengandung beberapa baris, kirim per baris
                    $lines = explode("\n", $chunk);
                    foreach ($lines as $line) {
                        echo "data: " . json_encode(['type' => 'output', 'line' => $line]) . "\n\n";
                        flush();
                    }
                }

                $result = $process->wait();

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
            'X-Accel-Buffering' => 'no', // matikan buffering Nginx
            'Connection'        => 'keep-alive',
        ]);
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
