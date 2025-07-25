<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kurikulum extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodi_id',
        'name',
        'academic_year',
        'total_credits',
        'document_url',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'total_credits' => 'integer'
    ];

    // Relationships
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    public function mataKuliahs(): HasMany
    {
        return $this->hasMany(MataKuliah::class, 'kurikulum_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    // Accessors
    public function getDocumentUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
