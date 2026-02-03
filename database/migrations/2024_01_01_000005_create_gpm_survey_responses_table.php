<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_survey_responses
     * Purpose: Menyimpan jawaban responden untuk setiap pertanyaan survey
     */
    public function up(): void
    {
        Schema::create('gpm_survey_responses', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('survey_id')
                  ->constrained('gpm_surveys')
                  ->onDelete('cascade');
            
            $table->foreignId('question_id')
                  ->constrained('gpm_survey_questions')
                  ->onDelete('cascade');
            
            // Respondent Info (nullable for anonymous surveys)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            
            $table->string('respondent_identifier')->nullable(); // session ID or unique token for anonymous
            $table->string('respondent_email')->nullable();
            $table->string('respondent_name')->nullable();
            
            // Response Data
            $table->text('answer')->nullable(); // jawaban dalam bentuk text/json
            $table->json('answer_data')->nullable(); // untuk multiple answers (checkbox)
            $table->integer('rating_value')->nullable(); // untuk rating/scale questions
            
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
            
            // Unique constraint untuk prevent duplicate responses (jika allow_multiple = false)
            // Di aplikasi level, bukan database level karena ada kondisi
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
