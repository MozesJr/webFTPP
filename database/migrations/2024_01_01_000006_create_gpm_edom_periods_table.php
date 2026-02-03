<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_edom_periods
     * Purpose: Menyimpan periode EDOM (Evaluasi Dosen Oleh Mahasiswa)
     */
    public function up(): void
    {
        Schema::create('gpm_edom_periods', function (Blueprint $table) {
            $table->id();
            
            // Period Information
            $table->string('name'); // e.g., "EDOM Semester Ganjil 2024/2025"
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('academic_year'); // e.g., "2024/2025"
            
            // Period Dates
            $table->date('start_date');
            $table->date('end_date');
            
            // Description
            $table->text('description')->nullable();
            $table->text('instructions')->nullable(); // instruksi untuk mahasiswa
            
            // Settings
            $table->boolean('is_active')->default(false);
            $table->boolean('is_published')->default(false); // hasil published untuk dosen
            $table->boolean('require_all_courses')->default(true); // mahasiswa harus isi semua matkul
            $table->boolean('show_results_to_students')->default(false);
            
            // Statistics
            $table->integer('total_students')->default(0);
            $table->integer('total_lecturers')->default(0);
            $table->integer('total_courses')->default(0);
            $table->integer('total_submissions')->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(0); // persentase keseluruhan
            
            // Relations
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('is_active');
            $table->index(['semester', 'academic_year']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_edom_periods');
    }
};
