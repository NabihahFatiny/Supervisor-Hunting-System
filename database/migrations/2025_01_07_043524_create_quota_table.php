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
        Schema::create('quota', function (Blueprint $table) {
            $table->id('quotaID');
            $table->unsignedBigInteger('Lecturer_id');
            $table->integer('Assigned_quota');
            $table->foreign('Lecturer_id')->references('lecturerID')->on('lecturers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quota');
    }
};
