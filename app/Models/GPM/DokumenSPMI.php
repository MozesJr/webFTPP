<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Str;

class DokumenSPMI extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_dokumen_spmi';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'document_code',
        'version',
        'published_date',
        'effective_date',
        'review_date',
        'download_count',
        'view_count',
        'is_published',
        'published_at',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'published_date' => 'date',
        'effective_date' => 'date',
        'review_date' => 'date',
        'file_size' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug when creating
        static::creating(function ($dokumen) {
            if (empty($dokumen->slug)) {
                $dokumen->slug = Str::slug($dokumen->title);
            }
        });

        // Update published_at when publishing
        static::updating(function ($dokumen) {
            if ($dokumen->isDirty('is_published') && $dokumen->is_published) {
                $dokumen->published_at = now();
            }
        });
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the file URL.
     */
    public function getFileUrlAttribute(): string
    {
        return asset($this->file_path);
    }

    /**
     * Get the file size in human readable format.
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get category badge color.
     */
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'standar' => 'blue',
            'manual' => 'green',
            'formulir' => 'purple',
            'sop' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'standar' => 'Standar SPMI',
            'manual' => 'Manual SPMI',
            'formulir' => 'Formulir',
            'sop' => 'SOP',
            default => 'Lainnya',
        };
    }

    /**
     * Increment download count.
     */
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    /**
     * Scope a query to only include published documents.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to search by title or description.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('document_code', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to order by most downloaded.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('download_count', 'desc');
    }

    /**
     * Scope to order by newest.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_date', 'desc');
    }
}
