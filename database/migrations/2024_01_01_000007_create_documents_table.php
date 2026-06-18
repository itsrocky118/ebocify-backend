<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('cascade');
            $table->foreignId('consignment_id')->nullable()->constrained('consignments')->onDelete('set null');
            $table->string('document_number', 100);
            $table->enum('status', ['draft', 'completed', 'archived'])->default('draft');
            $table->enum('creation_method', ['manual', 'ai'])->default('manual');
            $table->json('form_data')->nullable();
            $table->string('pdf_path', 255)->nullable();
            $table->timestamp('pdf_generated_at')->nullable();
            $table->integer('credits_used')->default(0);
            $table->integer('version')->default(1);
            $table->foreignId('cloned_from')->nullable()->constrained('documents')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
