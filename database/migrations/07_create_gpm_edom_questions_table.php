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
        Schema::create('gpm_edom_questions', function (Blueprint $table) {
            $table->id();
            
            // Question
            $table->text('question');
            $table->text('help_text')->nullable();
            
            // Category
            $table->enum('category', [
                'penguasaan_materi',    // Material mastery
                'metode_pengajaran',    // Teaching method
                'interaksi',            // Interaction
                'penilaian',            // Assessment
                'kedisiplinan',         // Discipline
                'komunikasi',           // Communication
                'motivasi',             // Motivation
                'umum'                  // General
            ])->default('umum');
            
            // Question Type
            $table->enum('type', [
                'rating',      // 1-5 rating
                'yes_no',      // Yes/No
                'text',        // Short text
                'textarea'     // Long text (feedback)
            ])->default('rating');
            
            // Rating Settings
            $table->integer('rating_min')->default(1);
            $table->integer('rating_max')->default(5);
            $table->string('rating_min_label')->nullable(); // "Sangat Tidak Baik"
            $table->string('rating_max_label')->nullable(); // "Sangat Baik"
            
            // Validation
            $table->boolean('is_required')->default(true);
            
            // Ordering
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('category');
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_edom_questions');
    }
};
