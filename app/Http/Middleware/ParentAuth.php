<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('parent')->check()) {
            return redirect()->route('parent.login');
        }

        // Check if parent account is active
        $parent = Auth::guard('parent')->user();
        if (!$parent->is_active) {
            Auth::guard('parent')->logout();
            return redirect()->route('parent.login')
                ->withErrors(['username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.']);
        }

        return $next($request);
    }
}
