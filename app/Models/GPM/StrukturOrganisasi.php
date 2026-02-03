<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturOrganisasi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_struktur_organisasi';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'email',
        'phone',
        'photo',
        'tugas_fungsi',
        'bio',
        'order',
        'is_active',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Get the photo URL.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset($this->photo) : null;
    }

    /**
     * Get the full name with title.
     */
    public function getFullNameWithTitleAttribute(): string
    {
        return $this->nama . ' - ' . $this->jabatan;
    }

    /**
     * Scope a query to only include active members.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured members.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope to get members by position/jabatan.
     */
    public function scopeByJabatan($query, string $jabatan)
    {
        return $query->where('jabatan', $jabatan);
    }

    /**
     * Get the next order number.
     */
    public static function getNextOrder(): int
    {
        return self::max('order') + 1;
    }
}
