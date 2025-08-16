<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CoreRolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create basic permissions
        $permissions = [
            'dashboard.view',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.manage-roles',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'about.view',
            'about.create',
            'about.edit',
            'about.delete',
            'about.toggle-status',
            'program-studi.view',
            'program-studi.create',
            'program-studi.edit',
            'program-studi.delete',
            'news.view',
            'news.create',
            'news.edit',
            'news.delete',
            'contact-messages.view',
            'contact-messages.reply',
            'contact-messages.delete',
            'settings.view',
            'settings.edit',
            'kurikulum.view',
            'kurikulum.create',
            'kurikulum.edit',
            'kurikulum.delete',
            'mata-kuliah.view',
            'mata-kuliah.create',
            'mata-kuliah.edit',
            'mata-kuliah.delete',
            'rps.view',
            'rps.create',
            'rps.edit',
            'rps.delete',
            'jadwal-kuliah.view',
            'jadwal-kuliah.create',
            'jadwal-kuliah.edit',
            'jadwal-kuliah.delete',
            'dosen-mata-kuliah.view',
            'dosen-mata-kuliah.create',
            'dosen-mata-kuliah.edit',
            'dosen-mata-kuliah.delete',
            'penjaminan-mutu.view',
            'penjaminan-mutu.create',
            'penjaminan-mutu.edit',
            'penjaminan-mutu.delete',
            'penjaminan-mutu.download',
            'site-settings.view',
            'site-settings.edit',
            'site-settings.bulk-update',
            'stats.view',
            'stats.create',
            'stats.edit',
            'stats.delete',
            'stats.set-current',
            'team.view',
            'team.create',
            'team.edit',
            'team.delete',
            'team.update-order',
            'team-position.view',
            'team-position.create',
            'team-position.edit',
            'team-position.delete',
            'parent.view-khs',
            'api.access',
        ];

        // Create permissions (only if they don't exist)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create or update roles

        // 1. SUPER ADMIN
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. ADMIN
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminPermissions = [
            'dashboard.view',
            'about.view',
            'about.create',
            'about.edit',
            'about.delete',
            'about.toggle-status',
            'program-studi.view',
            'program-studi.create',
            'program-studi.edit',
            'program-studi.delete',
            'news.view',
            'news.create',
            'news.edit',
            'news.delete',
            'contact-messages.view',
            'contact-messages.reply',
            'contact-messages.delete',
            'settings.view',
            'settings.edit',
            'kurikulum.view',
            'kurikulum.create',
            'kurikulum.edit',
            'kurikulum.delete',
            'mata-kuliah.view',
            'mata-kuliah.create',
            'mata-kuliah.edit',
            'mata-kuliah.delete',
            'rps.view',
            'rps.create',
            'rps.edit',
            'rps.delete',
            'jadwal-kuliah.view',
            'jadwal-kuliah.create',
            'jadwal-kuliah.edit',
            'jadwal-kuliah.delete',
            'dosen-mata-kuliah.view',
            'dosen-mata-kuliah.create',
            'dosen-mata-kuliah.edit',
            'dosen-mata-kuliah.delete',
            'penjaminan-mutu.view',
            'penjaminan-mutu.create',
            'penjaminan-mutu.edit',
            'penjaminan-mutu.delete',
            'penjaminan-mutu.download',
            'site-settings.view',
            'site-settings.edit',
            'site-settings.bulk-update',
            'stats.view',
            'stats.create',
            'stats.edit',
            'stats.delete',
            'stats.set-current',
            'team.view',
            'team.create',
            'team.edit',
            'team.delete',
            'team.update-order',
            'team-position.view',
            'team-position.create',
            'team-position.edit',
            'team-position.delete',
            'api.access',
        ];
        $admin->syncPermissions($adminPermissions);

        // 3. PETUGAS UMUM
        $petugasUmum = Role::firstOrCreate(['name' => 'petugas_umum', 'guard_name' => 'web']);
        $petugasPermissions = [
            'dashboard.view',
            // View permissions (read-only)
            'about.view',
            'program-studi.view',
            'kurikulum.view',
            'mata-kuliah.view',
            'rps.view',
            'jadwal-kuliah.view',
            'dosen-mata-kuliah.view',
            'penjaminan-mutu.view',
            'penjaminan-mutu.download',
            'site-settings.view',
            'stats.view',
            'team.view',
            'team-position.view',
            // Limited edit permissions
            'news.view',
            'news.create',
            'news.edit',
            'contact-messages.view',
            'contact-messages.reply',
            'jadwal-kuliah.edit',
            'api.access',
        ];
        $petugasUmum->syncPermissions($petugasPermissions);

        // 4. ORANG TUA
        $orangTua = Role::firstOrCreate(['name' => 'orang_tua', 'guard_name' => 'web']);
        $orangTua->syncPermissions([
            'dashboard.view',
            'parent.view-khs',
        ]);

        // Create default users (only if they don't exist)

        // Super Admin User
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@faculty.ac.id'],
            [
                'name' => 'Super Administrator',
                'password' => 'password',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $superAdminUser->assignRole('super_admin');

        // Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@faculty.ac.id'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $adminUser->assignRole('admin');

        // Petugas User
        $petugasUser = User::firstOrCreate(
            ['email' => 'petugas@faculty.ac.id'],
            [
                'name' => 'Petugas Umum',
                'password' => 'password',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $petugasUser->assignRole('petugas_umum');

        // Parent User (placeholder)
        $orangTuaUser = User::firstOrCreate(
            ['email' => 'orangtua@faculty.ac.id'],
            [
                'name' => 'Orang Tua Demo',
                'password' => 'password',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $orangTuaUser->assignRole('orang_tua');

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: superadmin@faculty.ac.id / password');
        $this->command->info('Admin: admin@faculty.ac.id / password');
        $this->command->info('Petugas: petugas@faculty.ac.id / password');
        $this->command->info('Parent: orangtua@faculty.ac.id / password');
    }
}
