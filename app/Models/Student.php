<?php
// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'birth_place',
        'address',
        'program_studi',
        'semester',
        'status',
        'tahun_masuk',
        'ipk',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'ipk' => 'decimal:2',
        'is_active' => 'boolean',
        'tahun_masuk' => 'integer',
    ];

    // Relationship
    public function parents()
    {
        return $this->hasMany(ParentModel::class);
    }

    public function parent()
    {
        return $this->hasOne(ParentModel::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getFormattedNimAttribute()
    {
        return strtoupper($this->nim);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => 'bg-green-100 text-green-800',
            'cuti' => 'bg-yellow-100 text-yellow-800',
            'lulus' => 'bg-blue-100 text-blue-800',
            'DO' => 'bg-red-100 text-red-800'
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function khsFiles(): HasMany
    {
        return $this->hasMany(KhsFile::class);
    }

    public function getKhsFilesByPeriod($periodId)
    {
        return $this->khsFiles()->byPeriod($periodId)->ready()->first();
    }

    public function hasKhsForPeriod($periodId): bool
    {
        return $this->khsFiles()->byPeriod($periodId)->ready()->exists();
    }

    public function getLatestKhsFile()
    {
        return $this->khsFiles()->ready()->latest('upload_date')->first();
    }
}
