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
        Schema::create('user_shs', function (Blueprint $table) {
            $table->id('user_Id'); // Primary key, auto-increment
            $table->string('username', 20)->unique();
            $table->string('temp_password', 60);
            $table->string('new_password', 60)->nullable();
            $table->enum('role', ['Lecturer', 'Student', 'Coordinator']);
            $table->timestamp('CreatedAt')->useCurrent();
            $table->string('raw_password')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shs');
    }
};
