<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjaminanMutu extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodi_id',
        'document_type',
        'title',
        'description',
        'document_url',
        'version',
        'effective_date',
        'review_date',
        'status',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'review_date' => 'date',
        'approved_at' => 'datetime'
    ];

    // Relationships
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    // Accessors
    public function getDocumentUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
