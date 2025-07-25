<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_students',
        'total_partnerships',
        'total_alumni',
        'total_lecturers',
        'year',
        'is_current'
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'year' => 'integer'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
