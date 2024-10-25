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
        Schema::table('party_a_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Adding user_id column after contract_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('party_a_infos', function (Blueprint $table) {
            //
        });
    }
};
