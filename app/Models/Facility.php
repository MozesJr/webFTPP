<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'image',
        'gallery',
        'location',
        'capacity',
        'area',
        'features',
        'contact_person',
        'contact_phone',
        'contact_email',
        'is_available',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'features' => 'array',
        'is_available' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    protected $appends = [
        'image_url',
        'gallery_urls',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });

        static::updating(function ($facility) {
            if ($facility->isDirty('name') && empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });

        static::deleting(function ($facility) {
            // Delete main image
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }

            // Delete gallery images
            if ($facility->gallery && is_array($facility->gallery)) {
                foreach ($facility->gallery as $galleryImage) {
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        });
    }

    // Accessor for main image URL
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::url($this->image);
    }

    // Accessor for gallery URLs
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->gallery);
    }

    // Scope for active facilities
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for available facilities
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope for ordered facilities
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc');
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }
}
