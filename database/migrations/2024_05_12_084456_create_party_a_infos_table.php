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
        Schema::create('party_a_infos', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->nullable();
            $table->string('email')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('address')->nullable();
            $table->string('recipient_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_a_infos');
    }
};
