<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('position_id')->constrained('team_positions');
            $table->foreignId('prodi_id')->nullable()->constrained('program_studis')->onDelete('set null');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->text('education')->nullable();
            $table->text('expertise')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
