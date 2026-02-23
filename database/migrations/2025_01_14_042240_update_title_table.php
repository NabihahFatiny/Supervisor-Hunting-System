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
        Schema::table('fyp_title', function (Blueprint $table) {
            // Add the foreign key constraint
            $table->foreign('PostID')->references('PostID')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Remove the foreign key constraint
         Schema::table('fyp_title', function (Blueprint $table) {
            $table->dropForeign(['PostID']);
        });
    }
};
