<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RpsWeeklyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rps_id',
        'week_number',
        'topic',
        'learning_materials',
        'teaching_methods',
        'assignments',
        'assessment',
        'references'
    ];

    protected $casts = [
        'week_number' => 'integer'
    ];

    // Relationships
    public function rps(): BelongsTo
    {
        return $this->belongsTo(Rps::class, 'rps_id');
    }

    // Scopes
    public function scopeByWeek($query, $week)
    {
        return $query->where('week_number', $week);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('week_number');
    }
}
