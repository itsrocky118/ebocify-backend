<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('transaction_type', ['plan_payment', 'credit_purchase', 'refund'])->default('credit_purchase');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 5)->default('USD');
            $table->string('payment_method', 50);
            $table->string('payment_gateway_id', 255)->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('billing_name', 200);
            $table->string('billing_email', 255);
            $table->text('billing_address')->nullable();
            $table->string('invoice_number', 100)->unique();
            $table->string('invoice_pdf_path', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
