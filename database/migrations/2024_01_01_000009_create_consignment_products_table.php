<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consignment_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consignment_id')->constrained('consignments')->onDelete('cascade');
            $table->text('description');
            $table->string('hs_code', 20)->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 20);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->decimal('net_weight', 10, 2)->nullable();
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->string('dimensions', 100)->nullable();
            $table->integer('packages_count')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consignment_products');
    }
};
