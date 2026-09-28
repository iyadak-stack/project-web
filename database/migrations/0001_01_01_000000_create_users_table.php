<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 10)->primary();

            $table->string('email', 255)->unique();
            $table->string('password', 255);

            $table->string('first_name', 50);
            $table->string('last_name', 50);

            $table->string('role', 20);
            $table->boolean('is_active')->default(true);
            $table->string('current_role', 45)->default('student');

            $table->string('profile_picture', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
