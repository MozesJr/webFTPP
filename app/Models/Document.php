<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_studi_id',
        'title',
        'description',
        'document_type',
        'file_url',
        'file_name',
        'file_size',
        'file_type',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'order_index' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function getFileUrlAttribute($value)
    {
        return $value ? asset('storage/' . ltrim($value, 'storage/')) : null;
    }

    public function setFileUrlAttribute($value)
    {
        if ($value && strpos($value, 'storage/') === 0) {
            $this->attributes['file_url'] = str_replace('storage/', '', $value);
        } else {
            $this->attributes['file_url'] = $value;
        }
    }
}
