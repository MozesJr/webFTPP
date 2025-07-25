<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'description'
    ];

    protected $casts = [
        'level' => 'integer'
    ];

    // Relationships
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'position_id');
    }

    // Scopes
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}
