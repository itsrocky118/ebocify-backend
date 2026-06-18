<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('consignment_number', 100)->unique();
            $table->string('exporter_name', 200);
            $table->text('exporter_address');
            $table->string('exporter_country', 100);
            $table->string('importer_name', 200);
            $table->text('importer_address');
            $table->string('importer_country', 100);
            $table->string('port_of_loading', 200);
            $table->string('port_of_discharge', 200);
            $table->date('shipment_date')->nullable();
            $table->string('vessel_flight_number', 200)->nullable();
            $table->json('container_numbers')->nullable();
            $table->string('incoterms', 10)->nullable();
            $table->string('payment_terms', 100)->nullable();
            $table->decimal('total_value', 15, 2);
            $table->string('currency', 5)->default('USD');
            $table->enum('status', ['active', 'shipped', 'completed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consignments');
    }
};
