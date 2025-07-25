<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage users',
            'manage program-studi',
            'manage kurikulum',
            'manage mata-kuliah',
            'manage news',
            'manage events',
            'manage gallery',
            'manage testimonials',
            'manage clients',
            'manage teams',
            'manage contact-messages',
            'manage settings',
            'view admin',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        $editorRole->givePermissionTo([
            'manage news',
            'manage events',
            'manage gallery',
            'manage testimonials',
            'view admin',
        ]);
    }
}
