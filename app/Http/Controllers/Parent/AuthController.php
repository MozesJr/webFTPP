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
    // ========================================
    // SHOW LOGIN FORM
    // ========================================

    public function showLogin()
    {
        return Inertia::render('Parent/Auth/Login');
    }

    // ========================================
    // HANDLE LOGIN
    // ========================================

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find parent by username
        $parent = ParentModel::where('username', $request->username)
            ->where('is_active', true)
            ->first();

        // Check credentials
        if (!$parent || !Hash::check($request->password, $parent->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        // Update last login
        $parent->update([
            'last_login_at' => now()
        ]);

        // Login using parent guard
        Auth::guard('parent')->login($parent, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('parent.dashboard'));
    }

    // ========================================
    // HANDLE LOGOUT
    // ========================================

    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('parent.login');
    }

    // ========================================
    // SHOW CHANGE PASSWORD FORM
    // ========================================

    public function showChangePassword()
    {
        return Inertia::render('Parent/Auth/ChangePassword');
    }

    // ========================================
    // HANDLE CHANGE PASSWORD
    // ========================================

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

    // ========================================
    // FORGOT PASSWORD (Optional)
    // ========================================

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

        // In real implementation, you would send an email
        // For now, we'll just show the default password
        $defaultPassword = $parent->student->nim . '123';

        return back()->with('flash', [
            'type' => 'info',
            'message' => "Password default Anda adalah: {$defaultPassword}. Silakan hubungi admin jika perlu bantuan."
        ]);
    }
}
