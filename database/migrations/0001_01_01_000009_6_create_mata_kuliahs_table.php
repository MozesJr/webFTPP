<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id')->constrained('kurikulums')->onDelete('cascade');
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->integer('credits');
            $table->integer('semester');
            $table->enum('category', ['wajib', 'pilihan', 'mkdu', 'mkk', 'mkb', 'mbb']);
            $table->json('prerequisite')->nullable(); // Array of course codes
            $table->text('description')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
