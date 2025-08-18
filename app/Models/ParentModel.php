<?php

// app/Models/ParentModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

class ParentModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'parents';

    protected $fillable = [
        'student_id',
        'username',
        'password',
        'name',
        'email',
        'phone',
        'relation',
        'occupation',
        'address',
        'is_active',
        'last_login_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'timestamp',
        'password' => 'hashed', // Auto hash in Laravel 10+
    ];

    // Relationship
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRelation($query, $relation)
    {
        return $query->where('relation', $relation);
    }

    // Accessors & Mutators
    public function getRelationLabelAttribute()
    {
        $labels = ['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'];
        return $labels[$this->relation] ?? 'Unknown';
    }

    public function getRelationBadgeAttribute()
    {
        $badges = [
            'ayah' => 'bg-blue-100 text-blue-800',
            'ibu' => 'bg-pink-100 text-pink-800',
            'wali' => 'bg-gray-100 text-gray-800'
        ];
        return $badges[$this->relation] ?? 'bg-gray-100 text-gray-800';
    }

    // Custom Methods
    public function generateUsername()
    {
        return $this->student ? $this->student->nim : null;
    }

    public function generatePassword()
    {
        // Generate password: nim + birth_date (ddmmyyyy)
        $password = $this->student->nim;
        if ($this->student->birth_date) {
            $password .= $this->student->birth_date->format('dmY');
        } else {
            $password .= '01012000'; // default if no birth date
        }
        return $password;
    }

    // public function getStudentKhsFiles()
    // {
    //     return $this->student->khsFiles()->ready()
    //         ->with('academicPeriod')
    //         ->orderBy('academic_period_id', 'desc');
    // }

    public function canAccessKhs($khsFileId): bool
    {
        return $this->student->khsFiles()->where('id', $khsFileId)->ready()->exists();
    }

    // public function getAccessLogs($limit = 50)
    // {
    //     return ParentKhsAccessLog::byParent($this->id)
    //         ->with(['khsFile.academicPeriod'])
    //         ->recent()
    //         ->orderBy('accessed_at', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }

    // public function getKhsAccessStatistics($days = 30)
    // {
    //     $logs = ParentKhsAccessLog::byParent($this->id)->recent($days)->get();

    //     return [
    //         'total_access' => $logs->count(),
    //         'downloads' => $logs->where('access_type', 'download')->count(),
    //         'views' => $logs->where('access_type', 'view')->count(),
    //         'unique_files' => $logs->unique('khs_file_id')->count(),
    //         'last_access' => $logs->max('accessed_at'),
    //         'most_accessed_period' => $logs->groupBy('khsFile.academic_period_id')
    //             ->sortByDesc(function ($group) {
    //                 return $group->count();
    //             })
    //             ->keys()
    //             ->first()
    //     ];
    // }

    // Override auth identifier methods
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->username;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getStudentKhsFiles()
    {
        if (!$this->student) {
            return collect();
        }

        return $this->student->khsFiles()
            ->where('upload_status', 'ready')
            ->with('academicPeriod')
            ->orderBy('academic_period_id', 'desc');
    }

    public function getAccessLogs($limit = 50)
    {
        // Check if ParentKhsAccessLog model exists
        if (!class_exists(\App\Models\ParentKhsAccessLog::class)) {
            return collect();
        }

        return \App\Models\ParentKhsAccessLog::where('parent_id', $this->id)
            ->with(['khsFile.academicPeriod'])
            ->orderBy('accessed_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getKhsAccessStatistics($days = 30)
    {
        // Check if ParentKhsAccessLog model exists
        if (!class_exists(\App\Models\ParentKhsAccessLog::class)) {
            return [
                'total_access' => 0,
                'downloads' => 0,
                'views' => 0,
                'unique_files' => 0,
                'last_access' => null,
            ];
        }

        $logs = \App\Models\ParentKhsAccessLog::where('parent_id', $this->id)
            ->where('accessed_at', '>=', now()->subDays($days))
            ->get();

        return [
            'total_access' => $logs->count(),
            'downloads' => $logs->where('access_type', 'download')->count(),
            'views' => $logs->where('access_type', 'view')->count(),
            'unique_files' => $logs->unique('khs_file_id')->count(),
            'last_access' => $logs->max('accessed_at'),
        ];
    }
}
