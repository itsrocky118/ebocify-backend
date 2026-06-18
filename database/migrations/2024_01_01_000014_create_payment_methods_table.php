<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('gateway', 50);
            $table->string('gateway_customer_id', 255);
            $table->string('gateway_payment_method_id', 255);
            $table->string('card_brand', 50)->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_exp_month', 2)->nullable();
            $table->string('card_exp_year', 4)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
