<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhsAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'khs_file_id',
        'parent_id',
        'access_type',
        'accessed_at',
        'user_agent',
        'ip_address'
    ];

    protected $casts = [
        'accessed_at' => 'datetime'
    ];

    // Relationships
    public function khsFile()
    {
        return $this->belongsTo(KhsFile::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('accessed_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->where('accessed_at', '>=', now()->startOfWeek());
    }

    public function scopeThisMonth($query)
    {
        return $query->where('accessed_at', '>=', now()->startOfMonth());
    }

    public function scopeByAccessType($query, $type)
    {
        return $query->where('access_type', $type);
    }

    // Accessors
    public function getDeviceTypeAttribute()
    {
        if (!$this->user_agent) return 'Unknown';

        $userAgent = strtolower($this->user_agent);

        if (strpos($userAgent, 'mobile') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'tablet') !== false) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    public function getBrowserAttribute()
    {
        if (!$this->user_agent) return 'Unknown';

        $userAgent = strtolower($this->user_agent);

        if (strpos($userAgent, 'chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'edge') !== false) {
            return 'Edge';
        } else {
            return 'Unknown';
        }
    }
}
