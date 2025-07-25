<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'background_video_url',
        'explanation_video_url',
        'background_image_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active hero sections
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
