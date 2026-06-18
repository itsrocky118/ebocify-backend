<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('consignment_id')->constrained('consignments')->onDelete('cascade');
            $table->enum('status', ['in_progress', 'completed', 'failed'])->default('in_progress');
            $table->integer('total_checks')->default(0);
            $table->integer('passed_checks')->default(0);
            $table->integer('warning_checks')->default(0);
            $table->integer('failed_checks')->default(0);
            $table->decimal('score_percentage', 5, 2)->default(0);
            $table->integer('credits_used')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->string('report_pdf_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_results');
    }
};
