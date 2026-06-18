<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->boolean('email_document_created')->default(true);
            $table->boolean('email_credit_low')->default(true);
            $table->boolean('email_certificate_expiring')->default(true);
            $table->boolean('email_monthly_summary')->default(false);
            $table->boolean('email_product_updates')->default(false);
            $table->boolean('push_document_ready')->default(true);
            $table->boolean('push_audit_completed')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
