<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->string('Appointment_id', 10)->primary();
            $table->string('status', 45)->default('pending'); // pending, confirmed, cancelled
            $table->timestamp('start_datetime')->nullable();
            $table->timestamp('end_datetime')->nullable();
            
            // Foreign Keys
            $table->string('Subject_subject_id', 10);
            $table->string('Tutor_profiles_tutor_id', 10);
            $table->string('Student_profiles_student_id', 10);
            
            $table->timestamps();
            $table->softDeletes(); // deleted_at

            // Relationships
            $table->foreign('Subject_subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};