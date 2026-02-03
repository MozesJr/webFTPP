<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class EDOMSubmission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_edom_submissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'period_id',
        'student_id',
        'lecturer_id',
        'course_code',
        'course_name',
        'class',
        'sks',
        'evaluation_data',
        'total_score',
        'average_score',
        'total_questions_answered',
        'category_scores',
        'suggestions',
        'positive_feedback',
        'improvement_areas',
        'ip_address',
        'submitted_at',
        'is_complete',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'evaluation_data' => 'array',
        'category_scores' => 'array',
        'total_score' => 'decimal:2',
        'average_score' => 'decimal:2',
        'total_questions_answered' => 'integer',
        'sks' => 'integer',
        'submitted_at' => 'datetime',
        'is_complete' => 'boolean',
    ];

    /**
     * Get the period that owns the submission.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(EDOMPeriod::class, 'period_id');
    }

    /**
     * Get the student who submitted.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the lecturer being evaluated.
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Get course full name with code.
     */
    public function getCourseFullNameAttribute(): string
    {
        return "{$this->course_code} - {$this->course_name}";
    }

    /**
     * Get class display (with SKS).
     */
    public function getClassDisplayAttribute(): string
    {
        $display = "Kelas {$this->class}";
        
        if ($this->sks) {
            $display .= " ({$this->sks} SKS)";
        }
        
        return $display;
    }

    /**
     * Get average score label.
     */
    public function getAverageScoreLabelAttribute(): string
    {
        $avg = $this->average_score;
        
        if ($avg >= 4.5) return 'Sangat Baik';
        if ($avg >= 3.5) return 'Baik';
        if ($avg >= 2.5) return 'Cukup';
        if ($avg >= 1.5) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Get score color for UI.
     */
    public function getScoreColorAttribute(): string
    {
        $avg = $this->average_score;
        
        if ($avg >= 4.5) return 'green';
        if ($avg >= 3.5) return 'blue';
        if ($avg >= 2.5) return 'yellow';
        if ($avg >= 1.5) return 'orange';
        return 'red';
    }

    /**
     * Get completion percentage.
     */
    public function getCompletionPercentageAttribute(): float
    {
        $period = $this->period;
        
        if (!$period || $period->total_questions_answered === 0) {
            return 0;
        }
        
        return ($this->total_questions_answered / $period->total_questions_answered) * 100;
    }

    /**
     * Get answer for specific question.
     */
    public function getAnswerForQuestion(int $questionId)
    {
        return $this->evaluation_data["question_{$questionId}"] ?? null;
    }

    /**
     * Get score for specific category.
     */
    public function getCategoryScore(string $category): ?float
    {
        return $this->category_scores[$category] ?? null;
    }

    /**
     * Calculate scores from evaluation data.
     */
    public function calculateScores(): void
    {
        if (empty($this->evaluation_data)) {
            return;
        }

        $totalScore = 0;
        $totalQuestions = 0;
        $categoryScores = [];
        $categoryCount = [];

        foreach ($this->evaluation_data as $key => $data) {
            if (!is_array($data) || !isset($data['answer'])) {
                continue;
            }

            $answer = $data['answer'];
            $category = $data['category'] ?? 'umum';

            // Only count rating answers
            if (is_numeric($answer)) {
                $totalScore += $answer;
                $totalQuestions++;

                // Calculate category scores
                if (!isset($categoryScores[$category])) {
                    $categoryScores[$category] = 0;
                    $categoryCount[$category] = 0;
                }

                $categoryScores[$category] += $answer;
                $categoryCount[$category]++;
            }
        }

        // Calculate averages
        $averageScore = $totalQuestions > 0 ? $totalScore / $totalQuestions : 0;

        foreach ($categoryScores as $category => $score) {
            $categoryScores[$category] = $categoryCount[$category] > 0 
                ? round($score / $categoryCount[$category], 2) 
                : 0;
        }

        // Update model
        $this->update([
            'total_score' => $totalScore,
            'average_score' => round($averageScore, 2),
            'total_questions_answered' => $totalQuestions,
            'category_scores' => $categoryScores,
        ]);
    }

    /**
     * Scope: Filter by period
     */
    public function scopeForPeriod($query, int $periodId)
    {
        return $query->where('period_id', $periodId);
    }

    /**
     * Scope: Filter by student
     */
    public function scopeForStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope: Filter by lecturer
     */
    public function scopeForLecturer($query, int $lecturerId)
    {
        return $query->where('lecturer_id', $lecturerId);
    }

    /**
     * Scope: Filter by course
     */
    public function scopeForCourse($query, string $courseCode)
    {
        return $query->where('course_code', $courseCode);
    }

    /**
     * Scope: Complete submissions only
     */
    public function scopeComplete($query)
    {
        return $query->where('is_complete', true);
    }

    /**
     * Scope: Order by average score
     */
    public function scopeHighestScore($query)
    {
        return $query->orderBy('average_score', 'desc');
    }

    /**
     * Scope: Order by submission date
     */
    public function scopeLatestSubmissions($query)
    {
        return $query->orderBy('submitted_at', 'desc');
    }

    /**
     * Get average score for a lecturer in a period.
     */
    public static function getLecturerAverageScore(int $lecturerId, int $periodId): float
    {
        return self::forPeriod($periodId)
            ->forLecturer($lecturerId)
            ->complete()
            ->avg('average_score') ?? 0;
    }

    /**
     * Get submissions count for a lecturer in a period.
     */
    public static function getLecturerSubmissionsCount(int $lecturerId, int $periodId): int
    {
        return self::forPeriod($periodId)
            ->forLecturer($lecturerId)
            ->complete()
            ->count();
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Auto set submitted_at on create
        static::creating(function ($model) {
            if (is_null($model->submitted_at)) {
                $model->submitted_at = now();
            }
        });

        // Calculate scores after creating
        static::created(function ($model) {
            $model->calculateScores();
        });
    }
}
