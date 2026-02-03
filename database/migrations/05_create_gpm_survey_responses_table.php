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
        Schema::create('gpm_survey_responses', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('survey_id')->constrained('gpm_surveys')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('gpm_survey_questions')->onDelete('cascade');
            
            // Respondent (nullable for anonymous)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('respondent_identifier')->nullable(); // Session ID or token
            $table->string('respondent_email')->nullable();
            $table->string('respondent_name')->nullable();
            
            // Response Data
            $table->text('answer')->nullable();
            $table->json('answer_data')->nullable(); // For multiple answers (checkbox)
            $table->integer('rating_value')->nullable(); // For rating questions
            
            // Metadata
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['survey_id', 'created_at']);
            $table->index('question_id');
            $table->index('user_id');
            $table->index('respondent_identifier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_survey_responses');
    }
};
