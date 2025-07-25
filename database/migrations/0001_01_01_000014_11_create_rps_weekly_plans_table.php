<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rps_weekly_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_id')->constrained('rps')->onDelete('cascade');
            $table->integer('week_number');
            $table->string('topic', 500);
            $table->text('learning_materials')->nullable();
            $table->text('teaching_methods')->nullable();
            $table->text('assignments')->nullable();
            $table->text('assessment')->nullable();
            $table->text('references')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rps_weekly_plans');
    }
};
