<?php
// app/Http/Middleware/EnsureParentIsActive.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureParentIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $parent = Auth::guard('parent')->user();

        if (!$parent || !$parent->is_active) {
            Auth::guard('parent')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('parent.login')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Akun Anda tidak aktif. Silakan hubungi admin.'
                ]);
        }

        return $next($request);
    }
}
