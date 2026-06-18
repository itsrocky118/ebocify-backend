<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_type_id')->nullable()->constrained('document_types')->onDelete('set null');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->json('messages')->nullable();
            $table->json('extracted_data')->nullable();
            $table->foreignId('created_document_id')->nullable()->constrained('documents')->onDelete('set null');
            $table->integer('credits_used')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_conversations');
    }
};
