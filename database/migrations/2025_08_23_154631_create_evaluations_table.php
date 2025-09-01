<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('student_nim'); // dari parents table
            $table->string('student_email');
            $table->string('student_name')->nullable();
            $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
            $table->integer('semester_taken'); // Semester berapa mahasiswa
            $table->integer('lecturer_count'); // 1 atau 2 dosen
            $table->foreignId('lecturer_1_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('lecturer_2_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->enum('attendance_lecturer_1', ['0', '1-4', '5-8', '>9'])->nullable();
            $table->enum('attendance_lecturer_2', ['0', '1-4', '5-8', '>9'])->nullable();
            $table->text('general_suggestion')->nullable();
            $table->text('suggestion_lecturer_1')->nullable();
            $table->text('suggestion_lecturer_2')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();

            // Prevent duplicate submissions
            $table->unique(['student_nim', 'questionnaire_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
