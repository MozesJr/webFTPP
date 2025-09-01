<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questionnaire_scale_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
            $table->integer('value'); // 1, 2, 3, 4
            $table->string('label'); // Tidak Memuaskan, Cukup Memuaskan, dll
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questionnaire_scale_options');
    }
};
