<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'views_count',
        'is_featured',
        'tags',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'is_featured' => 'boolean',
        'tags' => 'array'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Route key name for URL binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Accessors
    public function getFeaturedImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-news.jpg');
    }
}
