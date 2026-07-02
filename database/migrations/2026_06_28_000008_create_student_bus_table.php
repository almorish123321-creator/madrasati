<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_bus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('bus_id')->constrained('buses')->cascadeOnDelete();
            $table->string('pickup_point')->nullable();
            $table->string('dropoff_point')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('bus_id');
            $table->unique(['student_id', 'bus_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_bus');
    }
};