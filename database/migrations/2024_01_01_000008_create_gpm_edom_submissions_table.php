<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_edom_submissions
     * Purpose: Menyimpan hasil evaluasi dosen oleh mahasiswa
     */
    public function up(): void
    {
        Schema::create('gpm_edom_submissions', function (Blueprint $table) {
            $table->id();
            
            // Relation
            $table->foreignId('period_id')
                  ->constrained('gpm_edom_periods')
                  ->onDelete('cascade');
            
            // Student Info (yang mengisi EDOM)
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Lecturer Info (yang dievaluasi)
            $table->foreignId('lecturer_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Course Info
            $table->string('course_code'); // kode mata kuliah, e.g., "TPR-301"
            $table->string('course_name'); // nama mata kuliah
            $table->string('class')->nullable(); // kelas, e.g., "A", "B"
            $table->integer('sks')->nullable(); // jumlah SKS
            
            // Evaluation Data (JSON format untuk fleksibilitas)
            $table->json('evaluation_data'); // berisi array jawaban per question_id
            /**
             * Example structure:
             * {
             *   "question_1": {"answer": 5, "category": "penguasaan_materi"},
             *   "question_2": {"answer": 4, "category": "metode_pengajaran"},
             *   ...
             * }
             */
            
            // Computed Scores (untuk query yang lebih cepat)
            $table->decimal('total_score', 5, 2)->default(0); // total skor
            $table->decimal('average_score', 5, 2)->default(0); // rata-rata skor
            $table->integer('total_questions_answered')->default(0);
            
            // Category Scores (rata-rata per kategori)
            $table->json('category_scores')->nullable();
            /**
             * Example:
             * {
             *   "penguasaan_materi": 4.5,
             *   "metode_pengajaran": 4.2,
             *   ...
             * }
             */
            
            // Suggestions & Comments
            $table->text('suggestions')->nullable(); // saran untuk dosen
            $table->text('positive_feedback')->nullable(); // hal positif
            $table->text('improvement_areas')->nullable(); // area yang perlu diperbaiki
            
            // Metadata
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('is_complete')->default(true);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('period_id');
            $table->index('student_id');
            $table->index('lecturer_id');
            $table->index('course_code');
            $table->index('submitted_at');
            $table->index('average_score');
            
            // Unique constraint: satu mahasiswa hanya bisa isi EDOM untuk satu dosen di satu mata kuliah per periode
            $table->unique(['period_id', 'student_id', 'lecturer_id', 'course_code'], 'unique_edom_submission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_edom_submissions');
    }
};
