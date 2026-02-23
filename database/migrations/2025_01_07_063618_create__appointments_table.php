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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('lecturer_id');
            $table->dateTime('appointment_date');
            $table->enum('status', ['Approved', 'Rejected']);
            $table->foreign('student_id')->references('student_Id')->on('student')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('lecturerID')->on('lecturers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_appointments');
    }
};
