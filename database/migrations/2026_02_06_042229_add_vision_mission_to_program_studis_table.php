<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            if (!Schema::hasColumn('program_studis', 'vision')) {
                $table->text('vision')->nullable()->after('overview');
            }
            if (!Schema::hasColumn('program_studis', 'mission')) {
                $table->text('mission')->nullable()->after('vision');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->dropColumn(['vision', 'mission']);
        });
    }
};
