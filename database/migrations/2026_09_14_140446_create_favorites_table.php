<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            // Primary Key
            $table->id();
            // User ที่กด Favorite
            $table->integer('user_id');
            // ประเภทของข้อมูลที่ถูก Favorite
            $table->string('favoritable_type');
            // ID ของข้อมูลที่ถูก Favorite
            $table->integer('favoritable_id');
            // วันที่สร้างและแก้ไขข้อมูล
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};