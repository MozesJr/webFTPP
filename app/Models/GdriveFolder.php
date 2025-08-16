<?php
// app/Models/GdriveFolder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdriveFolder extends Model
{
    protected $fillable = [
        'folder_name',
        'gdrive_folder_id',
        'parent_folder_id',
        'folder_type',
        'academic_period_id',
        'program_studi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('folder_type', $type);
    }
}
