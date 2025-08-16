<?php
// app/Http/Controllers/SuperAdmin/UserController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->when($request->role, function ($q) use ($request) {
                $q->whereHas('roles', function ($query) use ($request) {
                    $query->where('name', $request->role);
                });
            })
            ->when(isset($request->is_active), function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roles = Role::orderBy('name')->get();

        return Inertia::render('SuperAdmin/Users/Index', [
            'users' => $query,
            'filters' => $request->only(['search', 'role', 'is_active']),
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return Inertia::render('SuperAdmin/Users/Create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Auto-hashed in Laravel 11
            'is_active' => $request->is_active ?? true,
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()
            ->route('super-admin.users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User berhasil ditambahkan!'
            ]);
    }

    public function show(User $user)
    {
        $user->load('roles.permissions');

        return Inertia::render('SuperAdmin/Users/Show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::orderBy('name')->get();

        return Inertia::render('SuperAdmin/Users/Edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active ?? true,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password; // Auto-hashed
        }

        $user->update($data);

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()
            ->route('super-admin.users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User berhasil diperbarui!'
            ]);
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('super-admin.users.index')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Anda tidak dapat menghapus akun sendiri.'
                ]);
        }

        // Prevent deleting last super admin
        if ($user->hasRole('super_admin')) {
            $superAdminCount = User::role('super_admin')->where('is_active', true)->count();
            if ($superAdminCount <= 1) {
                return redirect()
                    ->route('super-admin.users.index')
                    ->with('flash', [
                        'type' => 'error',
                        'message' => 'Tidak dapat menghapus Super Admin terakhir.'
                    ]);
            }
        }

        $user->delete();

        return redirect()
            ->route('super-admin.users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User berhasil dihapus.'
            ]);
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating yourself
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun sendiri.'
            ], 422);
        }

        // Prevent deactivating last super admin
        if ($user->hasRole('super_admin') && $user->is_active) {
            $activeSuperAdmins = User::role('super_admin')->where('is_active', true)->count();
            if ($activeSuperAdmins <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menonaktifkan Super Admin terakhir.'
                ], 422);
            }
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diubah.',
            'is_active' => $user->is_active
        ]);
    }
}
