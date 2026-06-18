<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->string('default_currency', 5)->default('USD');
            $table->string('timezone', 50)->default('Asia/Dhaka');
            $table->string('date_format', 20)->default('DD/MM/YYYY');
            $table->string('language', 10)->default('en');
            $table->enum('theme', ['light', 'dark', 'system'])->default('light');
            $table->boolean('compact_mode')->default(false);
            $table->integer('items_per_page')->default(10);
            $table->foreignId('default_document_type_id')->nullable()->constrained('document_types')->onDelete('set null');
            $table->boolean('auto_save_drafts')->default(true);
            $table->boolean('auto_assign_consignment_id')->default(true);
            $table->boolean('show_credit_cost')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
