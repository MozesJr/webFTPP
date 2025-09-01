<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_nim',
        'student_email',
        'student_name',
        'questionnaire_id',
        'semester_taken',
        'lecturer_count',
        'lecturer_1_id',
        'lecturer_2_id',
        'attendance_lecturer_1',
        'attendance_lecturer_2',
        'general_suggestion',
        'suggestion_lecturer_1',
        'suggestion_lecturer_2',
        'submitted_at'
    ];

    protected $casts = [
        'semester_taken' => 'integer',
        'lecturer_count' => 'integer',
        'submitted_at' => 'datetime'
    ];

    // Relationships
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function lecturer1(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'lecturer_1_id');
    }

    public function lecturer2(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'lecturer_2_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(EvaluationAnswer::class);
    }

    // Scopes
    public function scopeByQuestionnaire($query, $questionnaireId)
    {
        return $query->where('questionnaire_id', $questionnaireId);
    }

    public function scopeByNim($query, $nim)
    {
        return $query->where('student_nim', $nim);
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->whereHas('questionnaire', function ($q) use ($prodiId) {
            $q->where('prodi_id', $prodiId);
        });
    }

    public function scopeByLecturer($query, $lecturerId)
    {
        return $query->where(function ($q) use ($lecturerId) {
            $q->where('lecturer_1_id', $lecturerId)
                ->orWhere('lecturer_2_id', $lecturerId);
        });
    }

    // Methods
    public function getAverageScoreForLecturer($lecturerId): float
    {
        $answers = $this->answers()
            ->where('lecturer_id', $lecturerId)
            ->whereHas('question', function ($q) {
                $q->where('input_type', 'radio');
            })
            ->get();

        if ($answers->isEmpty()) return 0;

        $total = $answers->sum(function ($answer) {
            return (float) $answer->answer_value;
        });

        return round($total / $answers->count(), 2);
    }

    public function getLecturers(): array
    {
        $lecturers = [];

        if ($this->lecturer1) {
            $lecturers['lecturer_1'] = $this->lecturer1;
        }

        if ($this->lecturer2) {
            $lecturers['lecturer_2'] = $this->lecturer2;
        }

        return $lecturers;
    }
}
