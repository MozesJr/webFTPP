<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gpm_edom_submissions', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('period_id')->constrained('gpm_edom_periods')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lecturer_id')->constrained('users')->onDelete('cascade');
            
            // Course Information
            $table->string('course_code'); // e.g., "TPR-301"
            $table->string('course_name');
            $table->string('class')->nullable(); // e.g., "A", "B"
            $table->integer('sks')->nullable();
            
            // Evaluation Data (JSON for flexibility)
            $table->json('evaluation_data'); 
            /**
             * Structure:
             * {
             *   "question_1": {"answer": 5, "category": "penguasaan_materi"},
             *   "question_2": {"answer": 4, "category": "metode_pengajaran"},
             *   ...
             * }
             */
            
            // Computed Scores (for faster queries)
            $table->decimal('total_score', 5, 2)->default(0);
            $table->decimal('average_score', 5, 2)->default(0);
            $table->integer('total_questions_answered')->default(0);
            
            // Category Scores
            $table->json('category_scores')->nullable();
            /**
             * Structure:
             * {
             *   "penguasaan_materi": 4.5,
             *   "metode_pengajaran": 4.2,
             *   ...
             * }
             */
            
            // Comments
            $table->text('suggestions')->nullable();
            $table->text('positive_feedback')->nullable();
            $table->text('improvement_areas')->nullable();
            
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
            $table->index('average_score');
            
            // Unique: One student can only submit one EDOM per lecturer per course per period
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
