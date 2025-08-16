<?php
// app/Http/Middleware/HandleInertiaRequests.php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active ?? true,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ] : null,
                // Roles dan permissions terpisah di level auth
                'roles' => $user ? $user->getRoleNames()->toArray() : [],
                'permissions' => $user ? $user->getAllPermissions()->pluck('name')->toArray() : [],
                'is_super_admin' => $user ? $user->hasRole('super_admin') : false,
                'is_admin' => $user ? $user->hasRole('admin') : false,
                'is_petugas' => $user ? $user->hasRole('petugas_umum') : false,
                'is_parent' => $user ? $user->hasRole('orang_tua') : false,
            ],
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'error' => fn() => $request->session()->get('error'),
                'success' => fn() => $request->session()->get('success'),
                'type' => fn() => $request->session()->get('type'),
            ],
            // Add unread messages count if you have that feature
            'unreadMessagesCount' => function () use ($request) {
                if ($request->user() && $request->user()->hasRole(['admin', 'super_admin', 'petugas_umum'])) {
                    try {
                        // Replace with your actual ContactMessage model if different
                        return \App\Models\ContactMessage::where('is_read', false)->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                }
                return 0;
            },
            // Current route information
            'currentRoute' => [
                'name' => $request->route()?->getName(),
                'parameters' => $request->route()?->parameters() ?? [],
            ],
        ]);
    }
}
