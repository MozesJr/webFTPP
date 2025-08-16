<?php
// app/Http/Controllers/SuperAdmin/DashboardController.php - Update untuk debugging

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Debug: Check if user has roles
        $user = auth()->user();
        Log::info('Super Admin Dashboard - User roles:', [
            'user_id' => $user->id,
            'roles' => $user->getRoleNames()->toArray(),
            'is_super_admin' => $user->hasRole('super_admin')
        ]);

        // Statistics untuk dashboard
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
        ];

        // User breakdown by role
        $usersByRole = Role::withCount('users')->get()->map(function ($role) {
            return [
                'name' => $role->name,
                'display_name' => ucwords(str_replace('_', ' ', $role->name)),
                'users_count' => $role->users_count,
            ];
        });

        // Recent users (last 5)
        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at->format('d M Y'),
                ];
            });

        $data = [
            'stats' => $stats,
            'usersByRole' => $usersByRole,
            'recentUsers' => $recentUsers,
            // Explicitly pass user data
            'currentUser' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'is_super_admin' => $user->hasRole('super_admin'),
            ]
        ];

        // dd($data);

        return Inertia::render('SuperAdmin/Dashboard', $data);
    }
}
