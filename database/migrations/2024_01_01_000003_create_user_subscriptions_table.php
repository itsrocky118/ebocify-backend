<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->enum('status', ['active', 'cancelled', 'expired', 'past_due'])->default('active');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamp('cancelled_at')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
