<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_surveys';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'introduction',
        'closing_message',
        'target_respondent',
        'start_date',
        'end_date',
        'is_active',
        'is_anonymous',
        'allow_multiple_responses',
        'show_results',
        'require_login',
        'target_responses',
        'total_responses',
        'total_questions',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_anonymous' => 'boolean',
        'allow_multiple_responses' => 'boolean',
        'show_results' => 'boolean',
        'require_login' => 'boolean',
        'target_responses' => 'integer',
        'total_responses' => 'integer',
        'total_questions' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug
        static::creating(function ($survey) {
            if (empty($survey->slug)) {
                $survey->slug = Str::slug($survey->title);
            }
        });
    }

    /**
     * Get the creator of the survey.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the questions for the survey.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('order');
    }

    /**
     * Get the responses for the survey.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    /**
     * Get the target respondent label.
     */
    public function getTargetRespondentLabelAttribute(): string
    {
        return match($this->target_respondent) {
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            'alumni' => 'Alumni',
            'stakeholder' => 'Stakeholder',
            default => 'Umum',
        };
    }

    /**
     * Get the status of the survey.
     */
    public function getStatusAttribute(): string
    {
        $now = now();
        
        if (!$this->is_active) {
            return 'inactive';
        }
        
        if ($now->lt($this->start_date)) {
            return 'upcoming';
        }
        
        if ($now->gt($this->end_date)) {
            return 'ended';
        }
        
        return 'active';
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'inactive' => 'Tidak Aktif',
            'upcoming' => 'Akan Datang',
            'ended' => 'Selesai',
            'active' => 'Aktif',
            default => 'Unknown',
        };
    }

    /**
     * Get completion percentage.
     */
    public function getCompletionPercentageAttribute(): float
    {
        if (!$this->target_responses || $this->target_responses === 0) {
            return 0;
        }
        
        return min(100, ($this->total_responses / $this->target_responses) * 100);
    }

    /**
     * Check if survey is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        return $this->is_active 
            && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Check if user can fill the survey.
     */
    public function canBeFilled(): bool
    {
        return $this->isCurrentlyActive();
    }

    /**
     * Increment response count.
     */
    public function incrementResponses(): void
    {
        $this->increment('total_responses');
    }

    /**
     * Update question count.
     */
    public function updateQuestionCount(): void
    {
        $this->update([
            'total_questions' => $this->questions()->count()
        ]);
    }

    /**
     * Scope a query to only include active surveys.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get currently running surveys.
     */
    public function scopeCurrentlyRunning($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    /**
     * Scope to filter by target respondent.
     */
    public function scopeForTarget($query, string $target)
    {
        return $query->where('target_respondent', $target);
    }

    /**
     * Scope to search surveys.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
