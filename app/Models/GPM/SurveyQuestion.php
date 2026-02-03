<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_survey_questions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'survey_id',
        'question',
        'help_text',
        'type',
        'options',
        'rating_min',
        'rating_max',
        'rating_min_label',
        'rating_max_label',
        'is_required',
        'min_length',
        'max_length',
        'order',
        'section',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'rating_min' => 'integer',
        'rating_max' => 'integer',
        'min_length' => 'integer',
        'max_length' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the survey that owns the question.
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the responses for the question.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'question_id');
    }

    /**
     * Get the question type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'text' => 'Text Singkat',
            'textarea' => 'Text Panjang',
            'rating' => 'Rating',
            'multiple_choice' => 'Pilihan Ganda',
            'checkbox' => 'Multiple Selection',
            'yes_no' => 'Ya/Tidak',
            'scale' => 'Skala Likert',
            'dropdown' => 'Dropdown',
            default => 'Unknown',
        };
    }

    /**
     * Check if question is rating type.
     */
    public function isRatingType(): bool
    {
        return in_array($this->type, ['rating', 'scale']);
    }

    /**
     * Check if question has options.
     */
    public function hasOptions(): bool
    {
        return in_array($this->type, ['multiple_choice', 'checkbox', 'dropdown']) 
            && !empty($this->options);
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
     * Get next order number for survey.
     */
    public static function getNextOrder(int $surveyId): int
    {
        return self::where('survey_id', $surveyId)->max('order') + 1;
    }

    /**
     * Scope to order by question order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope to filter by question type.
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get required questions only.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope to filter by section.
     */
    public function scopeSection($query, ?string $section)
    {
        return $query->where('section', $section);
    }
}
