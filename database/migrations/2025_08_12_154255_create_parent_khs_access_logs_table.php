<?php

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
            $table->foreignId('khs_file_id')->constrained()->onDelete('cascade');
            $table->enum('access_type', ['view', 'download']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('accessed_at')->useCurrent();

            // No created_at/updated_at timestamps for logs

            // Indexes for analytics
            $table->index(['parent_id', 'accessed_at'], 'idx_parent_access');
            $table->index(['khs_file_id', 'accessed_at'], 'idx_khs_access');
            $table->index('access_type', 'idx_access_type');
            $table->index('accessed_at', 'idx_accessed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_khs_access_logs');
    }
};
