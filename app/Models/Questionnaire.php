<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'prodi_id',
        'semester',
        'academic_year',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // ========================
    // Relationships
    // ========================
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(QuestionnaireCategory::class)->orderBy('order_index');
    }

    public function scaleOptions(): HasMany
    {
        return $this->hasMany(QuestionnaireScaleOption::class)->orderBy('value');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    // ========================
    // Scopes
    // ========================
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeCurrent($query)
    {
        $today = now()->toDateString();

        return $query->where(function ($q) use ($today) {
            $q->where(function ($subQuery) use ($today) {
                $subQuery->whereNotNull('start_date')
                    ->whereNotNull('end_date')
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
            })
                ->orWhere(function ($subQuery) use ($today) {
                    $subQuery->whereNotNull('start_date')
                        ->whereNull('end_date')
                        ->where('start_date', '<=', $today);
                })
                ->orWhere(function ($subQuery) use ($today) {
                    $subQuery->whereNull('start_date')
                        ->whereNotNull('end_date')
                        ->where('end_date', '>=', $today);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->whereNull('start_date')
                        ->whereNull('end_date');
                });
        });
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    public function scopeByAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // ========================
    // Helper Methods
    // ========================
    public function getTotalQuestions(): int
    {
        return $this->categories->sum(function ($category) {
            return $category->questions->count();
        });
    }

    public function getSubmissionCount(): int
    {
        return $this->evaluations()->count();
    }

    public function isAvailable(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->toDateString();

        if ($this->start_date && $this->start_date > $today) return false;
        if ($this->end_date && $this->end_date < $today) return false;

        return true;
    }

    public function isAvailableFor($nim, $email): bool
    {
        if (!$this->isAvailable()) return false;

        return !$this->evaluations()
            ->where('student_nim', $nim)
            ->exists();
    }

    // ========================
    // Status Helpers
    // ========================
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) return 'inactive';

        $today = now()->toDateString();

        if ($this->start_date && $this->start_date > $today) return 'upcoming';
        if ($this->end_date && $this->end_date < $today) return 'expired';

        return 'active';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'upcoming' => 'Akan Datang',
            'expired' => 'Berakhir',
            default => 'Unknown'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'upcoming' => 'warning',
            'expired' => 'danger',
            default => 'secondary'
        };
    }
}
