<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'academic_year',
        'semester',
        'class_name',
        'day',
        'start_time',
        'end_time',
        'room',
        'capacity',
        'enrolled_students',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'capacity' => 'integer',
        'enrolled_students' => 'integer'
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForSemester($query, $academicYear, $semester)
    {
        return $query->where('academic_year', $academicYear)
            ->where('semester', $semester);
    }

    public function scopeByDay($query, $day)
    {
        return $query->where('day', $day);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->enrolled_students < $this->capacity;
    }

    public function getAvailableSlots()
    {
        return $this->capacity - $this->enrolled_students;
    }
}
