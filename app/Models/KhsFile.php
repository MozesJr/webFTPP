<?php
// app/Models/KhsFile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class KhsFile extends Model
{
    protected $fillable = [
        'student_id',
        'academic_period_id',
        'original_filename',
        'file_size',
        'mime_type',
        'gdrive_file_id',
        'gdrive_folder_id',
        'gdrive_url',
        'gdrive_download_url',
        'upload_status',
        'uploaded_by',
        'upload_date',
        'last_accessed_at',
        'access_count',
        'semester_name',
        'student_nim',
        'student_name'
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'last_accessed_at' => 'datetime',
        'file_size' => 'integer',
        'access_count' => 'integer'
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(KhsAccessLog::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    public function scopeReady($query)
    {
        return $query->where('upload_status', 'ready');
    }

    public function scopeUploading($query)
    {
        return $query->where('upload_status', 'uploading');
    }

    public function scopeFailed($query)
    {
        return $query->where('upload_status', 'failed');
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByPeriod($query, $periodId)
    {
        return $query->where('academic_period_id', $periodId);
    }

    public function scopeByNim($query, $nim)
    {
        return $query->where('student_nim', $nim);
    }

    public function scopeRecentUploads($query, $days = 7)
    {
        return $query->where('upload_date', '>=', now()->subDays($days));
    }

    public function scopeFrequentlyAccessed($query, $minAccess = 5)
    {
        return $query->where('access_count', '>=', $minAccess);
    }

    // ========================================
    // ACCESSORS
    // ========================================

    public function getFileSizeHumanAttribute()
    {
        return $this->formatBytes($this->file_size);
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->upload_status) {
            'ready' => 'bg-green-100 text-green-800',
            'uploading' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->upload_status) {
            'ready' => 'Siap',
            'uploading' => 'Mengunggah',
            'failed' => 'Gagal',
            default => 'Unknown'
        };
    }

    public function getCanDownloadAttribute()
    {
        return $this->upload_status === 'ready' && !empty($this->gdrive_download_url);
    }

    public function getCanPreviewAttribute()
    {
        return $this->upload_status === 'ready' && !empty($this->gdrive_url);
    }

    public function getUploadedAtHumanAttribute()
    {
        return $this->upload_date?->diffForHumans();
    }

    public function getLastAccessedHumanAttribute()
    {
        return $this->last_accessed_at?->diffForHumans() ?? 'Belum pernah';
    }

    // ========================================
    // METHODS
    // ========================================

    public function incrementAccessCount()
    {
        $this->increment('access_count');
        $this->update(['last_accessed_at' => now()]);
    }

    public function logAccess($parentId, $accessType = 'view', $ipAddress = null, $userAgent = null)
    {
        KhsAccessLog::create([
            'parent_id' => $parentId,
            'khs_file_id' => $this->id,
            'access_type' => $accessType,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent()
        ]);

        $this->incrementAccessCount();
    }

    public function markAsReady($gdriveData = [])
    {
        $updateData = ['upload_status' => 'ready'];

        if (!empty($gdriveData)) {
            $updateData = array_merge($updateData, [
                'gdrive_file_id' => $gdriveData['file_id'] ?? null,
                'gdrive_folder_id' => $gdriveData['folder_id'] ?? null,
                'gdrive_url' => $gdriveData['view_url'] ?? null,
                'gdrive_download_url' => $gdriveData['download_url'] ?? null,
            ]);
        }

        $this->update($updateData);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'upload_status' => 'failed',
            'failure_reason' => $reason
        ]);
    }

    public function retry()
    {
        $this->update([
            'upload_status' => 'uploading',
            'failure_reason' => null
        ]);
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    private function formatBytes($size, $precision = 2)
    {
        if ($size === 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(($size ? log($size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $size /= pow(1024, $pow);

        return round($size, $precision) . ' ' . $units[$pow];
    }

    public function getAccessStatistics($days = 30)
    {
        $logs = $this->accessLogs()
            ->where('accessed_at', '>=', now()->subDays($days))
            ->get();

        return [
            'total_access' => $logs->count(),
            'unique_parents' => $logs->unique('parent_id')->count(),
            'views' => $logs->where('access_type', 'view')->count(),
            'downloads' => $logs->where('access_type', 'download')->count(),
            'last_access' => $logs->max('accessed_at'),
            'most_recent_parent' => $logs->sortByDesc('accessed_at')->first()?->parent
        ];
    }

    // ========================================
    // STATIC METHODS
    // ========================================

    public static function getUploadStatsByPeriod($periodId)
    {
        $stats = static::byPeriod($periodId)
            ->selectRaw('
                upload_status,
                COUNT(*) as count,
                SUM(file_size) as total_size,
                AVG(file_size) as avg_size
            ')
            ->groupBy('upload_status')
            ->get()
            ->keyBy('upload_status');

        return [
            'ready' => $stats->get('ready')?->count ?? 0,
            'uploading' => $stats->get('uploading')?->count ?? 0,
            'failed' => $stats->get('failed')?->count ?? 0,
            'total_size' => $stats->sum('total_size'),
            'average_size' => $stats->avg('avg_size') ?? 0,
        ];
    }

    public static function getRecentUploads($limit = 10)
    {
        return static::with(['student', 'academicPeriod', 'uploader'])
            ->orderBy('upload_date', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function searchByStudentInfo($search)
    {
        return static::where(function ($query) use ($search) {
            $query->where('student_name', 'like', "%{$search}%")
                ->orWhere('student_nim', 'like', "%{$search}%");
        });
    }
}
