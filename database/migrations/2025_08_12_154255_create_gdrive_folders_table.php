<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gdrive_folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name');
            $table->string('gdrive_folder_id')->unique();
            $table->string('parent_folder_id')->nullable();
            $table->enum('folder_type', ['root', 'academic_year', 'semester', 'program_studi']);
            $table->foreignId('academic_period_id')->nullable()->constrained()->onDelete('set null');
            $table->string('program_studi', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('folder_type');
            $table->index('academic_period_id');
            $table->index('gdrive_folder_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gdrive_folders');
    }
};
