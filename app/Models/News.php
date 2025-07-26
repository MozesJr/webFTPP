<?php

// app/Models/News.php (dengan debugging dan safety attributes)
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

    // Relationships dengan default values untuk safety
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

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
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

    // Accessors dengan safety checks
    public function getFeaturedImageAttribute($value)
    {
        if (!$value) {
            return asset('storage/assets/img/news-default.jpg');
        }

        // Jika sudah full URL, return as is
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika path relatif, tambahkan storage path
        return asset('storage/' . $value);
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Auto generate excerpt from content if not set
        $content = $this->attributes['content'] ?? '';
        if (empty($content)) {
            return 'Deskripsi berita tidak tersedia...';
        }

        return substr(strip_tags($content), 0, 200) . '...';
    }

    public function getTitleAttribute($value)
    {
        return $value ?: 'Judul Berita';
    }

    public function getReadingTimeAttribute()
    {
        $content = $this->attributes['content'] ?? '';
        if (empty($content)) {
            return '1 menit baca';
        }

        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200); // Assuming 200 words per minute
        return $readingTime . ' menit baca';
    }

    // Tambahkan method untuk debugging
    public function toArray()
    {
        $array = parent::toArray();

        // Ensure category is loaded or provide default
        if (!isset($array['category']) && $this->relationLoaded('category')) {
            $array['category'] = $this->category ? $this->category->toArray() : [
                'id' => null,
                'name' => 'Umum',
                'slug' => 'umum'
            ];
        }

        // Ensure author is loaded or provide default
        if (!isset($array['author']) && $this->relationLoaded('author')) {
            $array['author'] = $this->author ? $this->author->toArray() : [
                'id' => null,
                'name' => 'Admin',
                'email' => null
            ];
        }

        return $array;
    }

    // Static method untuk search
    public static function search($query)
    {
        return static::where('title', 'like', '%' . $query . '%')
            ->orWhere('excerpt', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%');
    }
}
