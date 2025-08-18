<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KhsFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'academic_period_id',
        'student_name',
        'student_nim',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_size',
        'gdrive_file_id',
        'gdrive_folder_id',
        'upload_status',
        'upload_date',
        'uploaded_by',
        'error_message',
        'access_count',
        'last_accessed_at'
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'last_accessed_at' => 'datetime',
        'file_size' => 'integer',
        'access_count' => 'integer'
    ];

    protected $appends = [
        'status_label',
        'status_badge_class',
        'file_size_human',
        'last_accessed_human',
        'semester_name',
        'can_download',
        'gdrive_download_url',
        'gdrive_preview_url'
    ];

    // Status constants
    const STATUS_UPLOADING = 'uploading';
    const STATUS_READY = 'ready';
    const STATUS_FAILED = 'failed';

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function accessLogs()
    {
        return $this->hasMany(KhsAccessLog::class);
    }

    // Scopes
    public function scopeByPeriod($query, $periodId)
    {
        return $query->where('academic_period_id', $periodId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('upload_status', $status);
    }

    public function scopeReady($query)
    {
        return $query->where('upload_status', self::STATUS_READY);
    }

    public function scopeFailed($query)
    {
        return $query->where('upload_status', self::STATUS_FAILED);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        switch ($this->upload_status) {
            case self::STATUS_UPLOADING:
                return 'Mengunggah';
            case self::STATUS_READY:
                return 'Berhasil';
            case self::STATUS_FAILED:
                return 'Gagal';
            default:
                return 'Unknown';
        }
    }

    public function getStatusBadgeClassAttribute()
    {
        switch ($this->upload_status) {
            case self::STATUS_UPLOADING:
                return 'bg-yellow-100 text-yellow-800';
            case self::STATUS_READY:
                return 'bg-green-100 text-green-800';
            case self::STATUS_FAILED:
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) return '-';

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getLastAccessedHumanAttribute()
    {
        if (!$this->last_accessed_at) {
            return 'Belum pernah';
        }

        $diff = $this->last_accessed_at->diffForHumans();
        return ucfirst($diff);
    }

    public function getSemesterNameAttribute()
    {
        if ($this->academicPeriod) {
            return $this->academicPeriod->display_name ?? $this->academicPeriod->name;
        }
        return '-';
    }

    public function getCanDownloadAttribute()
    {
        return $this->upload_status === self::STATUS_READY && !empty($this->gdrive_file_id);
    }

    public function getGdriveDownloadUrlAttribute()
    {
        if (!$this->can_download) return null;

        return "https://drive.google.com/file/d/{$this->gdrive_file_id}/view";
    }

    public function getGdrivePreviewUrlAttribute()
    {
        if (!$this->can_download) return null;

        return "https://drive.google.com/file/d/{$this->gdrive_file_id}/preview";
    }

    // Methods
    public function markAsUploading()
    {
        $this->update([
            'upload_status' => self::STATUS_UPLOADING,
            'error_message' => null,
            'upload_date' => now()
        ]);
    }

    public function markAsReady($gdriveFileId)
    {
        $this->update([
            'upload_status' => self::STATUS_READY,
            'gdrive_file_id' => $gdriveFileId,
            'error_message' => null,
            'upload_date' => now()
        ]);
    }

    public function markAsFailed($errorMessage)
    {
        $this->update([
            'upload_status' => self::STATUS_FAILED,
            'error_message' => $errorMessage
        ]);
    }

    public function retry()
    {
        $this->markAsUploading();

        // Trigger upload job if you have queue system
        // dispatch(new UploadKhsToGoogleDriveJob($this));

        return $this;
    }

    public function incrementAccessCount($parentId = null, $accessType = 'view', $userAgent = null)
    {
        $this->increment('access_count');
        $this->update(['last_accessed_at' => now()]);

        // Log the access
        $this->accessLogs()->create([
            'parent_id' => $parentId,
            'access_type' => $accessType,
            'accessed_at' => now(),
            'user_agent' => $userAgent,
            'ip_address' => request()->ip()
        ]);

        return $this;
    }

    public function getAccessStatistics()
    {
        $accessLogs = $this->accessLogs();

        return [
            'total_access' => $this->access_count,
            'unique_users' => $accessLogs->distinct('parent_id')->count(),
            'today_access' => $accessLogs->whereDate('accessed_at', today())->count(),
            'week_access' => $accessLogs->where('accessed_at', '>=', now()->subWeek())->count(),
            'month_access' => $accessLogs->where('accessed_at', '>=', now()->subMonth())->count(),
            'last_access' => $this->last_accessed_at,
            'most_active_day' => $accessLogs
                ->selectRaw('DATE(accessed_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('count', 'desc')
                ->first()?->date
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_UPLOADING => 'Mengunggah',
            self::STATUS_READY => 'Berhasil',
            self::STATUS_FAILED => 'Gagal'
        ];
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($khsFile) {
            if (!$khsFile->upload_date) {
                $khsFile->upload_date = now();
            }
            if (!$khsFile->upload_status) {
                $khsFile->upload_status = self::STATUS_UPLOADING;
            }
        });

        static::deleting(function ($khsFile) {
            // Delete associated access logs
            $khsFile->accessLogs()->delete();
        });
    }
}
