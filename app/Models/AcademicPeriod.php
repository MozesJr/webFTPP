<?php
// app/Models/AcademicPeriod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AcademicPeriod extends Model
{
    protected $fillable = [
        'name',
        'year',
        'semester',
        'academic_year',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'year' => 'integer'
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function khsFiles(): HasMany
    {
        return $this->hasMany(KhsFile::class);
    }

    public function gdriveFolder(): HasOne
    {
        return $this->hasOne(GdriveFolder::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->limit($limit);
    }

    public function scopeByAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    // ========================================
    // ACCESSORS & MUTATORS
    // ========================================

    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->academic_year})";
    }

    public function getIsCurrentAttribute()
    {
        return $this->is_active;
    }

    public function getSemesterLabelAttribute()
    {
        return ucfirst($this->semester);
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_active
            ? 'bg-green-100 text-green-800'
            : 'bg-gray-100 text-gray-800';
    }

    // ========================================
    // COMPUTED PROPERTIES
    // ========================================

    public function getTotalStudentsAttribute()
    {
        return $this->khsFiles()->distinct('student_id')->count();
    }

    public function getUploadedFilesCountAttribute()
    {
        return $this->khsFiles()->where('upload_status', 'ready')->count();
    }

    public function getPendingFilesCountAttribute()
    {
        return $this->khsFiles()->where('upload_status', 'uploading')->count();
    }

    public function getFailedFilesCountAttribute()
    {
        return $this->khsFiles()->where('upload_status', 'failed')->count();
    }

    public function getUploadCompletionPercentageAttribute()
    {
        $total = $this->khsFiles()->count();
        if ($total === 0) return 0;

        $completed = $this->khsFiles()->where('upload_status', 'ready')->count();
        return round(($completed / $total) * 100, 2);
    }

    // ========================================
    // METHODS
    // ========================================

    public function activate()
    {
        // Deactivate all other periods
        static::where('is_active', true)->update(['is_active' => false]);

        // Activate this period
        $this->update(['is_active' => true]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function hasKhsForStudent($studentId)
    {
        return $this->khsFiles()->where('student_id', $studentId)->exists();
    }

    public function getKhsForStudent($studentId)
    {
        return $this->khsFiles()->where('student_id', $studentId)->first();
    }

    public function getUploadStatistics()
    {
        return [
            'total' => $this->khsFiles()->count(),
            'ready' => $this->uploaded_files_count,
            'uploading' => $this->pending_files_count,
            'failed' => $this->failed_files_count,
            'percentage' => $this->upload_completion_percentage,
            'total_students' => $this->total_students
        ];
    }

    // ========================================
    // STATIC METHODS
    // ========================================

    public static function getCurrentPeriod()
    {
        return static::active()->first();
    }

    public static function getAvailableYears()
    {
        return static::distinct('year')->orderBy('year', 'desc')->pluck('year');
    }

    public static function getPeriodsForYear($year)
    {
        return static::byYear($year)->orderBy('semester')->get();
    }

    public static function createNewPeriod($year, $semester, $name = null)
    {
        $academicYear = $semester === 'ganjil'
            ? "{$year}/" . ($year + 1)
            : ($year - 1) . "/{$year}";

        $name = $name ?: "Semester " . ucfirst($semester) . " {$academicYear}";

        return static::create([
            'name' => $name,
            'year' => $year,
            'semester' => $semester,
            'academic_year' => $academicYear,
            'is_active' => false
        ]);
    }
}
