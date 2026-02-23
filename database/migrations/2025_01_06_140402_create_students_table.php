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
        Schema::create('student', function (Blueprint $table) {
            $table->id('student_Id'); // Primary key, auto-increment
            $table->string('studName', 255);
            $table->string('studEmail', 255);
            $table->string('program', 255);
            $table->unsignedBigInteger('user_Id');
            $table->integer('lecturer_Id')->nullable()->unsigned();
            $table->integer('title_Id')->nullable()->unsigned();
            $table->integer('assignedgroup_id')->nullable()->unsigned();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
