<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_struktur_organisasi
     * Purpose: Menyimpan data struktur organisasi GPM FTPP
     */
    public function up(): void
    {
        Schema::create('gpm_struktur_organisasi', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan'); // Ketua, Sekretaris, Koordinator Audit, etc.
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // Photo
            $table->string('photo')->nullable(); // path to image
            
            // Job Description
            $table->text('tugas_fungsi')->nullable();
            $table->text('description')->nullable();
            
            // Ordering & Status
            $table->integer('order')->default(0); // untuk sorting display
            $table->boolean('is_active')->default(true);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('jabatan');
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_struktur_organisasi');
    }
};
