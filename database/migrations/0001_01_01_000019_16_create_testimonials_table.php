<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->text('content');
            $table->string('photo_url', 500)->nullable();
            $table->integer('rating')->default(5); // 1-5
            $table->foreignId('prodi_id')->nullable()->constrained('program_studis')->onDelete('set null');
            $table->enum('type', ['alumni', 'student', 'industry', 'parent'])->default('alumni');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
