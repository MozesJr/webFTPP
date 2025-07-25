<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@fakultas.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create editor user
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@fakultas.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $editor->assignRole('editor');

        // Create regular users
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
