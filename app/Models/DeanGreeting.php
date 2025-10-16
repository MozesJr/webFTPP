<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DeanGreeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'section_title',
        'section_subtitle',
        'greeting_text',
        'dean_name',
        'dean_title',
        'dean_degree',
        'dean_photo',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    protected $appends = [
        'full_dean_name',
        'dean_photo_url',
    ];

    // Accessor for full dean name with title and degree
    public function getFullDeanNameAttribute(): string
    {
        $parts = array_filter([
            $this->dean_title,
            $this->dean_name,
            $this->dean_degree,
        ]);

        return implode(' ', $parts);
    }

    // Accessor for dean photo URL
    public function getDeanPhotoUrlAttribute(): ?string
    {
        if (!$this->dean_photo) {
            return null;
        }

        return Storage::url($this->dean_photo);
    }

    // Scope for active greetings
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered greetings
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc');
    }

    // Delete photo when model is deleted
    protected static function booted()
    {
        static::deleting(function ($greeting) {
            if ($greeting->dean_photo && Storage::exists($greeting->dean_photo)) {
                Storage::delete($greeting->dean_photo);
            }
        });
    }
}
