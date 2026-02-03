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
        Schema::create('gpm_surveys', function (Blueprint $table) {
            $table->id();
            
            // Survey Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('introduction')->nullable(); // Welcome text for respondents
            $table->text('closing_message')->nullable(); // Thank you message
            
            // Target Respondent
            $table->enum('target_respondent', [
                'mahasiswa',
                'dosen', 
                'alumni',
                'stakeholder'
            ])->default('mahasiswa');
            
            // Period
            $table->date('start_date');
            $table->date('end_date');
            
            // Settings
            $table->boolean('is_active')->default(false);
            $table->boolean('is_anonymous')->default(true);
            $table->boolean('allow_multiple_responses')->default(false);
            $table->boolean('show_results')->default(false);
            $table->boolean('require_login')->default(false);
            
            // Statistics
            $table->integer('target_responses')->nullable(); // target jumlah responden
            $table->integer('total_responses')->default(0);
            $table->integer('total_questions')->default(0);
            
            // Relations
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('target_respondent');
            $table->index('is_active');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_surveys');
    }
};
