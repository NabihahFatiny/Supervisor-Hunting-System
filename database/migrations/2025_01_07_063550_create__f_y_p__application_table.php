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
        Schema::create('fyp_application', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('title_id');
            $table->string('custom_title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->enum('status', ['Pending', 'Accepted', 'Rejected']);
            $table->string('remarks', 255)->nullable();
            $table->dateTime('created_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_f_y_p__application');
    }
};
