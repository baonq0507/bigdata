<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->string('store_name');
            $table->string('phone_token')->nullable();
            $table->enum('gender',['male', 'female', 'non-binary', 'genderqueer', 'transgender', 'genderfluid', 'agender'])->nullable();
            $table->string('password');
            $table->string('delivery_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->enum('type', ['buyer','seller'])->default('buyer');
            $table->enum('field', ['leather_goods', 'clothing','all'])->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
