<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // "Semester Ganjil 2025/2026"
            $table->integer('year'); // 2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('academic_year', 20); // "2025/2026"
            $table->boolean('is_active')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['year', 'semester'], 'idx_year_semester');
            $table->index('is_active', 'idx_active');
            $table->index('academic_year', 'idx_academic_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
