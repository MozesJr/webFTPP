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
        Schema::create('gpm_survey_questions', function (Blueprint $table) {
            $table->id();
            
            // Relation
            $table->foreignId('survey_id')->constrained('gpm_surveys')->onDelete('cascade');
            
            // Question
            $table->text('question');
            $table->text('help_text')->nullable();
            
            // Question Type
            $table->enum('type', [
                'text',           // Short text
                'textarea',       // Long text
                'rating',         // 1-5 rating
                'multiple_choice', // Radio buttons
                'checkbox',       // Multiple selection
                'yes_no',         // Yes/No
                'scale',          // Likert scale
                'dropdown'        // Select dropdown
            ])->default('text');
            
            // Options (for multiple choice, checkbox, dropdown)
            $table->json('options')->nullable(); // ['Option 1', 'Option 2', ...]
            
            // Rating Settings
            $table->integer('rating_min')->nullable()->default(1);
            $table->integer('rating_max')->nullable()->default(5);
            $table->string('rating_min_label')->nullable(); // "Very Dissatisfied"
            $table->string('rating_max_label')->nullable(); // "Very Satisfied"
            
            // Validation
            $table->boolean('is_required')->default(true);
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            
            // Ordering
            $table->integer('order')->default(0);
            $table->string('section')->nullable(); // For grouping questions
            
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
