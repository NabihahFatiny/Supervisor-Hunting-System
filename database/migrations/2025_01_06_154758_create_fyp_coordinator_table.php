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
        Schema::create('fyp_coordinators', function (Blueprint $table) {
            $table->id('CoordinatorID');
            $table->string('Name');
            $table->string('Email');
            $table->unsignedBigInteger('user_Id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fyp_coordinator');
    }
};
