<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_code', 5)->nullable();
            $table->string('password');
            $table->string('avatar', 255)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('country', 100);
            $table->string('company_name', 200)->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_website', 255)->nullable();
            $table->string('erc_number', 50)->nullable();
            $table->string('tin_number', 50)->nullable();
            $table->string('bin_vat_number', 50)->nullable();
            $table->string('google_id', 255)->nullable();
            $table->string('apple_id', 255)->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
