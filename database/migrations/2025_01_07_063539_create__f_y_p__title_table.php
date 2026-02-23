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
        Schema::create('fyp_title', function (Blueprint $table) {
            $table->id('TitleID');
            $table->unsignedBigInteger('PostID');
            $table->string('TitleName', 255);
            $table->string('TitleDescription', 255);
            $table->integer('Quota');
            $table->integer('current_quota')->default(0);
            $table->enum('TitleStatus', ['Available']);
            $table->foreign('PostID')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_f_y_p__title');
    }
};
