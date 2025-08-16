<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('parent')->check()) {
            return redirect()->route('parent.dashboard');
        }

        return $next($request);
    }
}
