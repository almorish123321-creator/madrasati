<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('behavioral_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('type', ['positive', 'negative']);
            $table->text('description');
            $table->integer('points')->default(0);
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->date('date');
            $table->timestamps();

            $table->index('student_id');
            $table->index('type');
            $table->index(['student_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('behavioral_records');
    }
};