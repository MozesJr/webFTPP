<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('program_studis')->onDelete('cascade');
            $table->string('name');
            $table->string('academic_year', 9); // 2023/2024
            $table->integer('total_credits');
            $table->string('document_url', 500)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
