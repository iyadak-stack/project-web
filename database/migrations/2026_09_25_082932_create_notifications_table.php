<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('notification_id', 10)->primary();
            $table->string('message', 200);
            $table->boolean('is_read')->default(0);
            $table->string('Users_user_id', 10);
            $table->string('NotificationType_notification_type_id', 10);
            $table->timestamps();

            // Foreign Keys
            $table->foreign('NotificationType_notification_type_id')
                  ->references('notification_type_id')
                  ->on('notification_types')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};