<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class SurveyResponse extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_survey_responses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'survey_id',
        'question_id',
        'user_id',
        'respondent_identifier',
        'respondent_email',
        'respondent_name',
        'answer',
        'answer_data',
        'rating_value',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'answer_data' => 'array',
        'rating_value' => 'integer',
    ];

    /**
     * Get the survey that owns the response.
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the question that owns the response.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    /**
     * Get the user who submitted the response (if not anonymous).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get respondent display name.
     */
    public function getRespondentDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }

        if ($this->respondent_name) {
            return $this->respondent_name;
        }

        if ($this->respondent_email) {
            return $this->respondent_email;
        }

        return 'Anonymous';
    }

    /**
     * Get formatted answer based on question type.
     */
    public function getFormattedAnswerAttribute(): string
    {
        $question = $this->question;

        if (!$question) {
            return $this->answer ?? '-';
        }

        return match($question->type) {
            'rating', 'scale' => $this->rating_value . ' / ' . $question->rating_max,
            'yes_no' => $this->answer === 'yes' ? 'Ya' : 'Tidak',
            'checkbox' => is_array($this->answer_data) 
                ? implode(', ', $this->answer_data) 
                : ($this->answer ?? '-'),
            default => $this->answer ?? '-',
        };
    }

    /**
     * Check if response is anonymous.
     */
    public function isAnonymous(): bool
    {
        return empty($this->user_id);
    }

    /**
     * Scope to filter by survey.
     */
    public function scopeForSurvey($query, int $surveyId)
    {
        return $query->where('survey_id', $surveyId);
    }

    /**
     * Scope to filter by question.
     */
    public function scopeForQuestion($query, int $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Scope to get responses from authenticated users only.
     */
    public function scopeAuthenticated($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope to get anonymous responses only.
     */
    public function scopeAnonymous($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope to get responses by respondent identifier.
     */
    public function scopeByIdentifier($query, string $identifier)
    {
        return $query->where('respondent_identifier', $identifier);
    }

    /**
     * Get average rating for a question.
     */
    public static function getAverageRating(int $questionId): float
    {
        return self::where('question_id', $questionId)
                   ->whereNotNull('rating_value')
                   ->avg('rating_value') ?? 0;
    }

    /**
     * Get rating distribution for a question.
     */
    public static function getRatingDistribution(int $questionId): array
    {
        $distribution = self::where('question_id', $questionId)
            ->whereNotNull('rating_value')
            ->selectRaw('rating_value, COUNT(*) as count')
            ->groupBy('rating_value')
            ->orderBy('rating_value')
            ->pluck('count', 'rating_value')
            ->toArray();

        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($distribution[$i])) {
                $distribution[$i] = 0;
            }
        }

        ksort($distribution);
        return $distribution;
    }
}
