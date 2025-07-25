<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has required role
        if (!$user->hasRole(['admin', 'editor'])) {
            // Log for debugging
            \Log::info('User access denied', [
                'user_id' => $user->id,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')->toArray()
            ]);

            abort(403, 'Access denied. Admin role required.');
        }

        return $next($request);
    }
}
