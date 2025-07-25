<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('description');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->string('video_url', 500)->nullable();
            $table->string('video_title')->nullable();
            $table->text('video_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
