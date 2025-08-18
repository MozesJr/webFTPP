<?php
// app/Http/Middleware/HandleInertiaRequests.php (FIXED)

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $parent = Auth::guard('parent')->user(); // Parent authentication

        return array_merge(parent::share($request), [
            'auth' => [
                // Admin/User authentication (existing)
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active ?? true,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ] : null,

                // Parent authentication (new) - only when parent is logged in
                'parent' => $parent ? [
                    'id' => $parent->id,
                    'name' => $parent->name,
                    'username' => $parent->username,
                    'email' => $parent->email,
                    'phone' => $parent->phone,
                    'relation' => $parent->relation,
                    'relation_label' => $parent->relation_label,
                    'relation_badge' => $parent->relation_badge,
                    'occupation' => $parent->occupation,
                    'address' => $parent->address,
                    'is_active' => $parent->is_active,
                    'last_login_at' => $parent->last_login_at,
                ] : null,

                'student' => $parent && $parent->student ? [
                    'id' => $parent->student->id,
                    'nim' => $parent->student->nim,
                    'name' => $parent->student->name,
                    'email' => $parent->student->email,
                    'phone' => $parent->student->phone,
                    'gender' => $parent->student->gender,
                    'birth_date' => $parent->student->birth_date,
                    'birth_place' => $parent->student->birth_place,
                    'address' => $parent->student->address,
                    'program_studi' => $parent->student->program_studi,
                    'semester' => $parent->student->semester,
                    'status' => $parent->student->status,
                    'status_badge' => $parent->student->status_badge ?? 'bg-gray-100 text-gray-800',
                    'tahun_masuk' => $parent->student->tahun_masuk,
                    'ipk' => $parent->student->ipk,
                    'is_active' => $parent->student->is_active,
                ] : null,

                // Roles dan permissions - ONLY for admin users (not parents)
                'roles' => $user && method_exists($user, 'getRoleNames') ? $user->getRoleNames()->toArray() : [],
                'permissions' => $user && method_exists($user, 'getAllPermissions') ? $user->getAllPermissions()->pluck('name')->toArray() : [],
                'is_super_admin' => $user && method_exists($user, 'hasRole') ? $user->hasRole('super_admin') : false,
                'is_admin' => $user && method_exists($user, 'hasRole') ? $user->hasRole('admin') : false,
                'is_petugas' => $user && method_exists($user, 'hasRole') ? $user->hasRole('petugas_umum') : false,
                'is_parent' => $user && method_exists($user, 'hasRole') ? $user->hasRole('orang_tua') : false,

                // Parent authentication status (separate from user roles)
                'is_parent_authenticated' => $parent ? true : false,
            ],

            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'error' => fn() => $request->session()->get('error'),
                'success' => fn() => $request->session()->get('success'),
                'type' => fn() => $request->session()->get('type'),
            ],

            // Add unread messages count (only for admin users)
            'unreadMessagesCount' => function () use ($request) {
                $user = $request->user();
                if ($user && method_exists($user, 'hasRole') && $user->hasRole(['admin', 'super_admin', 'petugas_umum'])) {
                    try {
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
