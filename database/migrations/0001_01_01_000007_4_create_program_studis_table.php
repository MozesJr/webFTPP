<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->enum('degree_level', ['D3', 'S1', 'S2', 'S3']);
            $table->text('description')->nullable();
            $table->longText('overview')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->string('accreditation', 10)->nullable();
            $table->date('accreditation_date')->nullable();
            $table->date('accreditation_expire')->nullable();
            $table->string('head_of_program')->nullable();
            $table->year('established_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};
