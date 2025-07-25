<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'caption',
        'category',
        'prodi_id',
        'event_date',
        'is_active',
        'order_index'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'order_index' => 'integer'
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRecent($query, $limit = 12)
    {
        return $query->orderBy('event_date', 'desc')->limit($limit);
    }

    // Accessors
    public function getImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-gallery.jpg');
    }
}
