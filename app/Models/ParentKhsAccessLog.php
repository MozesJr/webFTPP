<?php
// app/Models/ParentKhsAccessLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentKhsAccessLog extends Model
{
    protected $fillable = [
        'parent_id',
        'khs_file_id',
        'access_type',
        'ip_address',
        'user_agent',
        'accessed_at'
    ];

    protected $casts = [
        'accessed_at' => 'datetime'
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class);
    }

    public function khsFile(): BelongsTo
    {
        return $this->belongsTo(KhsFile::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    public function scopeByParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    public function scopeByKhsFile($query, $khsFileId)
    {
        return $query->where('khs_file_id', $khsFileId);
    }

    public function scopeByAccessType($query, $type)
    {
        return $query->where('access_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('accessed_at', '>=', now()->subDays($days));
    }

    public function scopeDownloads($query)
    {
        return $query->where('access_type', 'download');
    }

    public function scopeViews($query)
    {
        return $query->where('access_type', 'view');
    }

    // ========================================
    // ACCESSORS
    // ========================================

    public function getAccessTypeIconAttribute()
    {
        return match ($this->access_type) {
            'download' => 'download',
            'view' => 'eye',
            'preview' => 'document-magnifying-glass',
            default => 'document'
        };
    }

    public function getAccessTypeColorAttribute()
    {
        return match ($this->access_type) {
            'download' => 'text-green-600',
            'view' => 'text-blue-600',
            'preview' => 'text-purple-600',
            default => 'text-gray-600'
        };
    }

    public function getAccessTypeLabelAttribute()
    {
        return match ($this->access_type) {
            'download' => 'Download',
            'view' => 'Lihat',
            'preview' => 'Preview',
            default => 'Unknown'
        };
    }

    public function getAccessedAtHumanAttribute()
    {
        return $this->accessed_at->diffForHumans();
    }

    // ========================================
    // BOOT METHOD
    // ========================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            if (!$log->accessed_at) {
                $log->accessed_at = now();
            }
        });
    }
}

// ========================================
// MIGRATION FILE
// ========================================

/*
<?php
// database/migrations/create_parent_khs_access_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_khs_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->onDelete('cascade');
            $table->foreignId('khs_file_id')->constrained('khs_files')->onDelete('cascade');
            $table->enum('access_type', ['view', 'download', 'preview'])->default('view');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('accessed_at')->useCurrent();
            $table->timestamps();

            // Indexes for performance
            $table->index(['parent_id', 'accessed_at'], 'idx_parent_access');
            $table->index(['khs_file_id', 'access_type'], 'idx_file_type');
            $table->index('accessed_at', 'idx_accessed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_khs_access_logs');
    }
};
*/
