<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_check_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_id')->constrained('audit_results')->onDelete('cascade');
            $table->string('check_category', 100);
            $table->string('check_name', 255);
            $table->text('check_description');
            $table->enum('status', ['passed', 'warning', 'failed', 'skipped'])->default('skipped');
            $table->json('details')->nullable();
            $table->json('document_ids_involved')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_check_items');
    }
};
