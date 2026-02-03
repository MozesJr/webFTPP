<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class EDOMPeriod extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_edom_periods';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'semester',
        'academic_year',
        'start_date',
        'end_date',
        'description',
        'instructions',
        'is_active',
        'is_published',
        'require_all_courses',
        'show_results_to_students',
        'total_students',
        'total_lecturers',
        'total_courses',
        'total_submissions',
        'completion_percentage',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'require_all_courses' => 'boolean',
        'show_results_to_students' => 'boolean',
        'total_students' => 'integer',
        'total_lecturers' => 'integer',
        'total_courses' => 'integer',
        'total_submissions' => 'integer',
        'completion_percentage' => 'decimal:2',
    ];

    /**
     * Get the creator of the period.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the submissions for the period.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(EDOMSubmission::class, 'period_id');
    }

    /**
     * Get semester label.
     */
    public function getSemesterLabelAttribute(): string
    {
        return match($this->semester) {
            'ganjil' => 'Ganjil',
            'genap' => 'Genap',
            default => 'Unknown',
        };
    }

    /**
     * Get full period name.
     */
    public function getFullPeriodNameAttribute(): string
    {
        return "Semester {$this->semester_label} {$this->academic_year}";
    }

    /**
     * Get the status of the period.
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = now();

        if ($now->lt($this->start_date)) {
            return 'upcoming';
        }

        if ($now->gt($this->end_date)) {
            return 'ended';
        }

        return 'active';
    }

    /**
     * Get status label.
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
     * Check if period is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        return $this->is_active 
            && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Check if student can submit EDOM.
     */
    public function canSubmit(): bool
    {
        return $this->isCurrentlyActive();
    }

    /**
     * Update completion percentage.
     */
    public function updateCompletionPercentage(): void
    {
        if ($this->total_students === 0) {
            $this->update(['completion_percentage' => 0]);
            return;
        }

        $uniqueStudents = $this->submissions()
            ->distinct('student_id')
            ->count('student_id');

        $percentage = ($uniqueStudents / $this->total_students) * 100;

        $this->update([
            'completion_percentage' => min(100, $percentage)
        ]);
    }

    /**
     * Update statistics.
     */
    public function updateStatistics(): void
    {
        $this->update([
            'total_submissions' => $this->submissions()->count(),
        ]);

        $this->updateCompletionPercentage();
    }

    /**
     * Scope a query to only include active periods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get currently running period.
     */
    public function scopeCurrentlyRunning($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    /**
     * Scope to get published periods.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to filter by semester.
     */
    public function scopeSemester($query, string $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope to filter by academic year.
     */
    public function scopeAcademicYear($query, string $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Get active period (singleton).
     */
    public static function getActivePeriod(): ?self
    {
        return self::currentlyRunning()->first();
    }
}
