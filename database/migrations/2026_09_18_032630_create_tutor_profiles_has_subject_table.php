<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tutor_profiles_has_Subject', function (Blueprint $table) {
            $table->unsignedBigInteger('Tutor_profiles_tutor_id');
            $table->char('Subject_subject_id', 10);

            $table->primary([
                'Tutor_profiles_tutor_id',
                'Subject_subject_id',
            ]);

            $table->foreign('Tutor_profiles_tutor_id')
                ->references('id')
                ->on('tutor_profiles')
                ->onDelete('cascade');

            $table->foreign('Subject_subject_id')
                ->references('Subjec_id')
                ->on('subjects')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tutor_profiles_has_Subject');
    }
};