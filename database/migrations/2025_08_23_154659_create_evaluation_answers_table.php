<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluation_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questionnaire_questions')->onDelete('cascade');
            $table->foreignId('lecturer_id')->nullable()->constrained('teams')->onDelete('cascade'); // null untuk pertanyaan umum
            $table->text('answer_value'); // bisa berupa angka atau text
            $table->timestamps();

            $table->index(['evaluation_id', 'question_id', 'lecturer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluation_answers');
    }
};
