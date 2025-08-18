<?php
// app/Http/Controllers/Parent/AuthController.php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Parent/Auth/Login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     // Find parent by username
    //     $parent = ParentModel::where('username', $request->username)
    //         ->where('is_active', true)
    //         ->first();

    //     // Check credentials
    //     if (!$parent || !Hash::check($request->password, $parent->password)) {
    //         throw ValidationException::withMessages([
    //             'username' => ['Username atau password salah.'],
    //         ]);
    //     }

    //     // Update last login
    //     $parent->update([
    //         'last_login_at' => now()
    //     ]);

    //     // Login using parent guard
    //     Auth::guard('parent')->login($parent, $request->boolean('remember'));

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('parent.dashboard'));
    // }

    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        $parent = ParentModel::where('username', $request->nim)
            ->where('is_active', true)
            ->first();

        // Lanjutkan dengan logika login yang sama
        if (!$parent || !Hash::check($request->password, $parent->password)) {
            return back()->withErrors([
                'nim' => 'NIM atau password salah.', // Ubah pesan error
            ])->onlyInput('nim');
        }

        $parent->update([
            'last_login_at' => now()
        ]);

        Auth::guard('parent')->login($parent, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('parent.dashboard'));
    }


    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showChangePassword()
    {
        return Inertia::render('Parent/Auth/ChangePassword', [
            'student' => Auth::guard('parent')->user()->student,
            'parent' => Auth::guard('parent')->user(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $parent = Auth::guard('parent')->user();

        // Check current password
        if (!Hash::check($request->current_password, $parent->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini salah.'],
            ]);
        }

        // Update password
        $parent->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('parent.dashboard')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Password berhasil diubah!'
            ]);
    }

    public function showForgotPassword()
    {
        return Inertia::render('Parent/Auth/ForgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $parent = ParentModel::where('username', $request->username)
            ->where('is_active', true)
            ->first();

        if (!$parent) {
            throw ValidationException::withMessages([
                'username' => ['Username tidak ditemukan.'],
            ]);
        }

        // Generate default password info
        $defaultPassword = $parent->student->nim . '01012000'; // Default format

        return back()->with('flash', [
            'type' => 'info',
            'message' => "Password default Anda adalah: {$defaultPassword}. Silakan hubungi admin jika perlu bantuan."
        ]);
    }
}
