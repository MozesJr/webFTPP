<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'content',
        'photo_url',
        'rating',
        'prodi_id',
        'type',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    // Relationships
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByRating($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    // Accessors
    public function getPhotoUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-avatar.png');
    }
}
