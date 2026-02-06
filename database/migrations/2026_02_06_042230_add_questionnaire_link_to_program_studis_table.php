<?php

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
        Schema::table('program_studis', function (Blueprint $table) {
            // Tambahkan kolom questionnaire_link jika belum ada
            if (!Schema::hasColumn('program_studis', 'questionnaire_link')) {
                $table->string('questionnaire_link', 500)->nullable()->after('mission');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->dropColumn('questionnaire_link');
        });
    }
};
