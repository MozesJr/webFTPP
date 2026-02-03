<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_edom_questions
     * Purpose: Template pertanyaan EDOM yang akan digunakan dalam evaluasi
     */
    public function up(): void
    {
        Schema::create('gpm_edom_questions', function (Blueprint $table) {
            $table->id();
            
            // Question Information
            $table->text('question');
            $table->text('help_text')->nullable();
            
            // Category/Aspect yang dievaluasi
            $table->enum('category', [
                'penguasaan_materi',      // Penguasaan materi pembelajaran
                'metode_pengajaran',      // Metode dan strategi pengajaran
                'interaksi',              // Interaksi dengan mahasiswa
                'penilaian',              // Sistem penilaian
                'kedisiplinan',           // Kedisiplinan dan profesionalisme
                'komunikasi',             // Komunikasi
                'motivasi',               // Kemampuan memotivasi
                'umum'                    // Pertanyaan umum
            ])->default('umum');
            
            // Question Type
            $table->enum('type', [
                'rating',        // Rating 1-5
                'yes_no',        // Ya/Tidak
                'text',          // Text singkat
                'textarea',      // Text panjang (saran/kritik)
            ])->default('rating');
            
            // Rating Settings
            $table->integer('rating_min')->default(1);
            $table->integer('rating_max')->default(5);
            $table->string('rating_min_label')->nullable(); // e.g., "Sangat Tidak Baik"
            $table->string('rating_max_label')->nullable(); // e.g., "Sangat Baik"
            
            // Validation
            $table->boolean('is_required')->default(true);
            
            // Ordering & Status
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
