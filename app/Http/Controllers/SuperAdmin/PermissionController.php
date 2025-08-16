<?php
// app/Http/Controllers/SuperAdmin/PermissionController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SuperAdmin/Permissions/Index', [
            'permissions' => $query,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('SuperAdmin/Permissions/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()
            ->route('super-admin.permissions.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Permission berhasil ditambahkan.'
            ]);
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');

        return Inertia::render('SuperAdmin/Permissions/Show', [
            'permission' => $permission
        ]);
    }

    public function edit(Permission $permission)
    {
        return Inertia::render('SuperAdmin/Permissions/Edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()
            ->route('super-admin.permissions.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Permission berhasil diperbarui.'
            ]);
    }

    public function destroy(Permission $permission)
    {
        // Check if permission is assigned to any roles
        if ($permission->roles()->count() > 0) {
            return redirect()
                ->route('super-admin.permissions.index')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Permission tidak dapat dihapus karena masih digunakan oleh role.'
                ]);
        }

        $permission->delete();

        return redirect()
            ->route('super-admin.permissions.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Permission berhasil dihapus.'
            ]);
    }
}
