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
        Schema::create('party_b_infos', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('tax_id');
            $table->string('bank_account_number');
            $table->string('bank_name');
            $table->string('business_name');
            $table->string('position');
            $table->string('address');
            $table->string('phone_number');
            $table->string('full_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_b_infos');
    }
};
