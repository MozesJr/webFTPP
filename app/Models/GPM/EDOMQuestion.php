<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EDOMQuestion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_edom_questions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question',
        'help_text',
        'category',
        'type',
        'rating_min',
        'rating_max',
        'rating_min_label',
        'rating_max_label',
        'is_required',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'rating_min' => 'integer',
        'rating_max' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'penguasaan_materi' => 'Penguasaan Materi',
            'metode_pengajaran' => 'Metode Pengajaran',
            'interaksi' => 'Interaksi dengan Mahasiswa',
            'penilaian' => 'Sistem Penilaian',
            'kedisiplinan' => 'Kedisiplinan',
            'komunikasi' => 'Komunikasi',
            'motivasi' => 'Motivasi',
            'umum' => 'Umum',
            default => 'Lainnya',
        };
    }

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'rating' => 'Rating (1-5)',
            'yes_no' => 'Ya/Tidak',
            'text' => 'Text Singkat',
            'textarea' => 'Text Panjang',
            default => 'Unknown',
        };
    }

    /**
     * Get category color for UI.
     */
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'penguasaan_materi' => 'blue',
            'metode_pengajaran' => 'green',
            'interaksi' => 'purple',
            'penilaian' => 'orange',
            'kedisiplinan' => 'red',
            'komunikasi' => 'indigo',
            'motivasi' => 'pink',
            'umum' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Check if question is rating type.
     */
    public function isRatingType(): bool
    {
        return $this->type === 'rating';
    }

    /**
     * Check if question requires text input.
     */
    public function requiresTextInput(): bool
    {
        return in_array($this->type, ['text', 'textarea']);
    }

    /**
     * Get rating range array.
     */
    public function getRatingRangeAttribute(): array
    {
        if (!$this->isRatingType()) {
            return [];
        }

        return range($this->rating_min ?? 1, $this->rating_max ?? 5);
    }

    /**
     * Scope: Active questions only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Order by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope: Filter by category
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by type
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Required questions only
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope: Rating questions only
     */
    public function scopeRatingQuestions($query)
    {
        return $query->where('type', 'rating');
    }

    /**
     * Scope: Text questions only
     */
    public function scopeTextQuestions($query)
    {
        return $query->whereIn('type', ['text', 'textarea']);
    }

    /**
     * Get questions grouped by category.
     */
    public static function getGroupedByCategory(): array
    {
        $questions = self::active()->ordered()->get();
        
        return $questions->groupBy('category')->map(function ($group) {
            return [
                'category' => $group->first()->category,
                'category_label' => $group->first()->category_label,
                'questions' => $group,
            ];
        })->values()->toArray();
    }

    /**
     * Get next order number.
     */
    public static function getNextOrder(): int
    {
        return self::max('order') + 1;
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Auto set order on create
        static::creating(function ($model) {
            if (is_null($model->order)) {
                $model->order = self::getNextOrder();
            }
        });
    }
}
