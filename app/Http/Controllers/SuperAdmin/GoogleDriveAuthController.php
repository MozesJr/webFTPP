<?php
// app/Http/Controllers/GoogleDriveAuthController.php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;

class GoogleDriveAuthController extends Controller
{
    private function client(): Google_Client
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id', env('GOOGLE_DRIVE_CLIENT_ID')));
        $client->setClientSecret(config('services.google.client_secret', env('GOOGLE_DRIVE_CLIENT_SECRET')));
        $client->setRedirectUri(env('GOOGLE_DRIVE_REDIRECT_URI'));

        // scope: pilih sesuai kebutuhan
        // DRIVE_FILE = akses file yang app buat/kelola
        // DRIVE = akses penuh (hati-hati)
        $client->setScopes([Google_Service_Drive::DRIVE_FILE]);

        // WAJIB untuk dapat refresh_token
        $client->setAccessType('offline');
        $client->setPrompt('consent'); // paksa consent tiap init supaya refresh_token dikirim
        // Optional (boleh iya/tidak)
        // $client->setIncludeGrantedScopes(true);

        return $client;
    }

    public function connect()
    {
        $client = $this->client();
        return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('gdrive.connect')->with('error', 'Kode OAuth tidak ada.');
        }

        $client = $this->client();
        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            return back()->with('error', 'OAuth error: ' . $token['error_description'] ?? $token['error']);
        }

        // Ambil refresh_token
        $refreshToken = $token['refresh_token'] ?? null;

        // Kadang Google tidak mengirim refresh_token jika user sudah pernah consent & tidak pakai prompt=consent
        if (!$refreshToken) {
            return back()->with('error', 'Google tidak mengembalikan refresh_token. Pastikan setAccessType("offline") & setPrompt("consent"), lalu coba lagi.');
        }

        // Tampilkan agar kamu bisa copy ke .env (atau simpan ke DB/secret manager)
        return response()->json([
            'message' => 'Copy nilai refresh_token berikut ke .env',
            'refresh_token' => $refreshToken,
        ]);
    }
}
