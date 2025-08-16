<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'profile_photo_path',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : asset('images/default-avatar.png');
    }

    // Helper methods
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isPetugas(): bool
    {
        return $this->hasRole('petugas_umum');
    }

    public function isParent(): bool
    {
        return $this->hasRole('orang_tua');
    }

    public function getDashboardRoute(): string
    {
        if ($this->isSuperAdmin()) {
            return route('super-admin.dashboard');
        }

        if ($this->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($this->isPetugas()) {
            return route('petugas.dashboard');
        }

        if ($this->isParent()) {
            return route('parent.dashboard');
        }

        return route('admin.dashboard');
    }

    public function getRoleDisplayName(): string
    {
        $roleNames = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'petugas_umum' => 'Petugas Umum',
            'orang_tua' => 'Orang Tua',
        ];

        $role = $this->getRoleNames()->first();
        return $roleNames[$role] ?? 'User';
    }

    // Accessors
    public function getImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-prodi.png');
    }
}
