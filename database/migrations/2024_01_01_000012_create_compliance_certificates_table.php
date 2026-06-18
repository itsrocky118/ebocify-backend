<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('certificate_type', 200);
            $table->string('certificate_number', 200);
            $table->string('issuing_authority', 200);
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->integer('reminder_days_before')->default(14);
            $table->string('document_copy_path', 255)->nullable();
            $table->enum('status', ['active', 'expiring_soon', 'expired', 'renewed'])->default('active');
            $table->date('last_renewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_certificates');
    }
};
