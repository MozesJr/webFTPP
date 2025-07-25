<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('teams')->onDelete('cascade');
            $table->string('academic_year', 9);
            $table->enum('semester', ['ganjil', 'genap', 'pendek']);
            $table->text('learning_objectives')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->text('assessment_methods')->nullable();
            $table->text('references')->nullable();
            $table->string('document_url', 500)->nullable();
            $table->enum('status', ['draft', 'approved', 'revision'])->default('draft');
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rps');
    }
};
