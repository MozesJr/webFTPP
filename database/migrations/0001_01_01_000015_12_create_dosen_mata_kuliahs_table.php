<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen_mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            $table->enum('role', ['koordinator', 'pengampu', 'asisten']);
            $table->string('academic_year', 9);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Use shorter constraint name
            $table->unique(['dosen_id', 'mata_kuliah_id', 'academic_year', 'role'], 'dosen_mk_year_role_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_mata_kuliahs');
    }
};
