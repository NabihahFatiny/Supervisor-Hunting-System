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
        Schema::create('assigned_group', function (Blueprint $table) {
            $table->id('assignedgroup_id');
            $table->string('group_name', 30);
            $table->unsignedBigInteger('lecturer_id');
            $table->string('lecturer_name', 20);
            $table->integer('Assigned_quota');
            $table->foreign('lecturer_id')->references('lecturerID')->on('lecturers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_assigned__group');
    }
};
