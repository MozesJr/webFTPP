<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->datetime('event_date');
            $table->datetime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->foreignId('prodi_id')->nullable()->constrained('program_studis')->onDelete('set null');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('organizer')->nullable();
            $table->text('requirements')->nullable();
            $table->string('registration_url', 500)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
