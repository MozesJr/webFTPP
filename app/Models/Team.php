<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position_id',
        'prodi_id',
        'email',
        'phone',
        'bio',
        'photo_url',
        'education',
        'expertise',
        'is_active',
        'order_index'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer'
    ];

    // Relationships
    public function position(): BelongsTo
    {
        return $this->belongsTo(TeamPosition::class, 'position_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    public function jadwalKuliahs(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class, 'dosen_id');
    }

    public function rps(): HasMany
    {
        return $this->hasMany(Rps::class, 'dosen_id');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function mataKuliahs(): BelongsToMany
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliahs', 'dosen_id', 'mata_kuliah_id')
            ->withPivot('role', 'academic_year', 'is_active')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    public function scopeByPosition($query, $positionId)
    {
        return $query->where('position_id', $positionId);
    }

    // Accessors
    public function getPhotoUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-avatar.png');
    }
}
