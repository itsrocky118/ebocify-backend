<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['institutional', 'commercial', 'financial']);
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            $table->integer('credit_cost_manual')->default(2);
            $table->integer('credit_cost_ai')->default(3);
            $table->string('icon', 100)->nullable();
            $table->json('form_schema')->nullable();
            $table->string('template_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
