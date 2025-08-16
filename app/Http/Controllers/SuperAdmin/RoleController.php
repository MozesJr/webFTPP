<?php
// app/Http/Controllers/SuperAdmin/RoleController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::withCount('users')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SuperAdmin/Roles/Index', [
            'roles' => $query,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0]; // Group by prefix (users, roles, etc.)
        });

        return Inertia::render('SuperAdmin/Roles/Create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()
            ->route('super-admin.roles.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Role berhasil ditambahkan.'
            ]);
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');

        return Inertia::render('SuperAdmin/Roles/Show', [
            'role' => $role
        ]);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return Inertia::render('SuperAdmin/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);

        // Sync permissions
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('super-admin.roles.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Role berhasil diperbarui.'
            ]);
    }

    public function destroy(Role $role)
    {
        // Prevent deleting roles that have users
        if ($role->users()->count() > 0) {
            return redirect()
                ->route('super-admin.roles.index')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Role tidak dapat dihapus karena masih memiliki user.'
                ]);
        }

        // Prevent deleting super_admin role
        if ($role->name === 'super_admin') {
            return redirect()
                ->route('super-admin.roles.index')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Role Super Admin tidak dapat dihapus.'
                ]);
        }

        $role->delete();

        return redirect()
            ->route('super-admin.roles.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Role berhasil dihapus.'
            ]);
    }
}
