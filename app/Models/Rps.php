<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rps extends Model
{
    use HasFactory;

    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'academic_year',
        'semester',
        'learning_objectives',
        'learning_outcomes',
        'assessment_methods',
        'references',
        'document_url',
        'status',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime'
    ];

    // Relationships
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'dosen_id');
    }

    public function weeklyPlans(): HasMany
    {
        return $this->hasMany(RpsWeeklyPlan::class, 'rps_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForSemester($query, $academicYear, $semester)
    {
        return $query->where('academic_year', $academicYear)
            ->where('semester', $semester);
    }

    // Helper methods
    public function approve($approverName)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approverName,
            'approved_at' => now()
        ]);
    }

    // Accessors
    public function getDocumentUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
