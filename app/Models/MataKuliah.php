<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kurikulum_id',
        'code',
        'name',
        'credits',
        'semester',
        'category',
        'prerequisite',
        'description',
        'learning_outcomes',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credits' => 'integer',
        'semester' => 'integer',
        'prerequisite' => 'array'
    ];

    // Relationships
    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    public function jadwalKuliahs(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class, 'mata_kuliah_id');
    }

    public function rps(): HasMany
    {
        return $this->hasMany(Rps::class, 'mata_kuliah_id');
    }

    public function dosens(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'dosen_mata_kuliahs', 'mata_kuliah_id', 'dosen_id')
            ->withPivot('role', 'academic_year', 'is_active')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper methods
    public function getPrerequisiteCourses()
    {
        if (!$this->prerequisite) {
            return collect();
        }

        return MataKuliah::whereIn('code', $this->prerequisite)->get();
    }
}
