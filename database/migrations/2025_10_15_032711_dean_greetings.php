<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dean_greetings', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->default('Sambutan');
            $table->string('section_subtitle')->default('Dekan FTPP UNIPA');
            $table->text('greeting_text');
            $table->string('dean_name');
            $table->string('dean_title')->nullable(); // e.g., "Prof. Dr. Ir."
            $table->string('dean_degree')->nullable(); // e.g., "MP"
            $table->string('dean_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dean_greetings');
    }
};
