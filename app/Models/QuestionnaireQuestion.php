<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionnaireQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question_text',
        'input_type',
        'options',
        'is_required',
        'is_for_lecturer',
        'order_index'
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_for_lecturer' => 'boolean',
        'order_index' => 'integer'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireCategory::class, 'category_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(EvaluationAnswer::class, 'question_id');
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeForLecturer($query)
    {
        return $query->where('is_for_lecturer', true);
    }

    public function scopeGeneral($query)
    {
        return $query->where('is_for_lecturer', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
