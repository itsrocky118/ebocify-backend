<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('device', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->timestamp('last_activity');
            $table->boolean('is_current_device')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
