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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('PostID');
            $table->unsignedBigInteger('LecturerID'); // Foreign key referencing the Lecturer table
            $table->string('PostTitle', 255);
            $table->string('PostCategory')->nullable(false)->change();  // Enforce NOT NULL
            $table->dateTime('PostDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
