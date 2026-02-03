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
        Schema::create('gpm_struktur_organisasi', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan'); // Ketua, Sekretaris, Koordinator Audit, dll
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // Photo
            $table->string('photo')->nullable(); // path to photo
            
            // Description
            $table->text('tugas_fungsi')->nullable(); // Tugas dan fungsi
            $table->text('bio')->nullable(); // Short bio
            
            // Organization
            $table->integer('order')->default(0); // For ordering/sorting
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // For main leader (Ketua)
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('jabatan');
            $table->index('order');
            $table->index('is_active');
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
