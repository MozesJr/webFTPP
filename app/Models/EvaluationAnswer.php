<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'question_id',
        'lecturer_id',
        'answer_value'
    ];

    // Relationships
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireQuestion::class, 'question_id');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'lecturer_id');
    }

    // Scopes
    public function scopeByLecturer($query, $lecturerId)
    {
        return $query->where('lecturer_id', $lecturerId);
    }

    public function scopeByQuestion($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    public function scopeRatingAnswers($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('input_type', 'radio');
        });
    }

    public function scopeTextAnswers($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('input_type', 'textarea');
        });
    }
}
