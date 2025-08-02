<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class About extends Model
{
    use HasFactory;

    protected $table = 'abouts';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'vision',
        'mission',
        'image_url',
        'video_url',
        'video_title',
        'video_description',
        'secondary_image_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope untuk mendapatkan data yang aktif
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor untuk mendapatkan URL gambar lengkap
     */
    public function getImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    /**
     * Accessor untuk mendapatkan URL gambar kedua lengkap
     */
    public function getSecondaryImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    /**
     * Mutator untuk menyimpan path gambar tanpa storage/
     */
    public function setImageUrlAttribute($value)
    {
        if ($value && strpos($value, 'storage/') === 0) {
            $this->attributes['image_url'] = str_replace('storage/', '', $value);
        } else {
            $this->attributes['image_url'] = $value;
        }
    }

    /**
     * Mutator untuk menyimpan path gambar kedua tanpa storage/
     */
    public function setSecondaryImageUrlAttribute($value)
    {
        if ($value && strpos($value, 'storage/') === 0) {
            $this->attributes['secondary_image_url'] = str_replace('storage/', '', $value);
        } else {
            $this->attributes['secondary_image_url'] = $value;
        }
    }
}
