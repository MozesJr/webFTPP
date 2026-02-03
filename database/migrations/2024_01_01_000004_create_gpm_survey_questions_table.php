<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_survey_questions
     * Purpose: Menyimpan pertanyaan-pertanyaan dalam survey
     */
    public function up(): void
    {
        Schema::create('gpm_survey_questions', function (Blueprint $table) {
            $table->id();
            
            // Relation
            $table->foreignId('survey_id')
                  ->constrained('gpm_surveys')
                  ->onDelete('cascade');
            
            // Question Information
            $table->text('question');
            $table->text('help_text')->nullable(); // petunjuk pengisian
            
            // Question Type
            $table->enum('type', [
                'text',           // text input
                'textarea',       // long text
                'rating',         // 1-5 stars or 1-10 scale
                'multiple_choice', // pilihan ganda (satu jawaban)
                'checkbox',       // pilihan ganda (multiple answers)
                'yes_no',         // ya/tidak
                'scale',          // likert scale (sangat setuju - sangat tidak setuju)
                'dropdown'        // dropdown select
            ])->default('text');
            
            // Options (for multiple choice, checkbox, dropdown)
            $table->json('options')->nullable(); // ['Option 1', 'Option 2', ...]
            
            // Rating Settings
            $table->integer('rating_min')->nullable()->default(1);
            $table->integer('rating_max')->nullable()->default(5);
            $table->string('rating_min_label')->nullable(); // e.g., "Sangat Tidak Puas"
            $table->string('rating_max_label')->nullable(); // e.g., "Sangat Puas"
            
            // Validation
            $table->boolean('is_required')->default(true);
            $table->integer('min_length')->nullable(); // untuk text/textarea
            $table->integer('max_length')->nullable(); // untuk text/textarea
            
            // Ordering & Grouping
            $table->integer('order')->default(0);
            $table->string('section')->nullable(); // untuk grouping pertanyaan
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['survey_id', 'order']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_survey_questions');
    }
};
