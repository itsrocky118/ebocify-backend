<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2);
            $table->integer('documents_per_month')->nullable();
            $table->boolean('has_ai_assistant')->default(false);
            $table->boolean('has_audit_tool')->default(false);
            $table->boolean('has_compliance_tracker')->default(false);
            $table->boolean('has_digital_vault')->default(false);
            $table->boolean('has_all_doc_types')->default(false);
            $table->boolean('has_priority_support')->default(false);
            $table->boolean('has_dedicated_manager')->default(false);
            $table->boolean('has_team_accounts')->default(false);
            $table->boolean('has_api_access')->default(false);
            $table->boolean('has_sla_guarantee')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
