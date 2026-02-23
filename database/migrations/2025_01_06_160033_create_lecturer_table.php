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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id('lecturerID');
            $table->string('lecturerName');
            $table->string('email');
            $table->string('current_quota')->nullable();
            $table->unsignedBigInteger('user_Id');
            $table->unsignedBigInteger('assignedgroup_id');
            $table->integer('assigned_quota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer');
    }
};
