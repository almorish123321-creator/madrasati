<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->constrained('homeworks')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['homework_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('homework_submissions');
    }
};