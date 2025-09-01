<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('questionnaire_categories')->onDelete('cascade');
            $table->text('question_text'); // Kerapian, Sikap Selama Mengajar, dll
            $table->enum('input_type', ['radio', 'textarea', 'select'])->default('radio');
            $table->json('options')->nullable(); // [1,2,3,4] untuk radio
            $table->boolean('is_required')->default(true);
            $table->boolean('is_for_lecturer')->default(true); // true jika untuk penilaian dosen
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questionnaire_questions');
    }
};
