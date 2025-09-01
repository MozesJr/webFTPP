<?php
// database/migrations/2025_09_01_add_prodi_id_to_students_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Add prodi_id column
            $table->unsignedBigInteger('prodi_id')->nullable()->after('program_studi');

            // Add foreign key constraint
            $table->foreign('prodi_id')->references('id')->on('program_studis')->onDelete('set null');

            // Add index for better performance
            $table->index('prodi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropIndex(['prodi_id']);
            $table->dropColumn('prodi_id');
        });
    }
};

// Setelah migration, buat data seeder untuk mapping program_studi string ke prodi_id
