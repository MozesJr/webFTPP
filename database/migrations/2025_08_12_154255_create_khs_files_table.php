<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('khs_files', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_period_id')->constrained()->onDelete('cascade');

            // File Information
            $table->string('original_filename');
            $table->integer('file_size')->default(0);
            $table->string('mime_type', 100)->default('application/pdf');

            // Google Drive Integration
            $table->string('gdrive_file_id')->unique()->nullable();
            $table->string('gdrive_folder_id')->nullable();
            $table->text('gdrive_url')->nullable();
            $table->text('gdrive_download_url')->nullable();

            // Status & Metadata
            $table->enum('upload_status', ['uploading', 'ready', 'failed'])->default('uploading');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('upload_date')->useCurrent();
            $table->timestamp('last_accessed_at')->nullable();
            $table->integer('access_count')->default(0);

            // Academic Info (denormalized for performance)
            $table->string('semester_name', 100)->nullable();
            $table->string('student_nim', 20)->nullable();
            $table->string('student_name')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['student_id', 'academic_period_id'], 'idx_student_period');
            $table->index('academic_period_id', 'idx_period');
            $table->index('student_id', 'idx_student');
            $table->index('gdrive_file_id', 'idx_gdrive');
            $table->index('upload_status', 'idx_status');
            $table->index('student_nim', 'idx_nim');
            $table->index('uploaded_by', 'idx_uploader');

            // Unique constraint (one KHS per student per period)
            $table->unique(['student_id', 'academic_period_id'], 'unique_student_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('khs_files');
    }
};
