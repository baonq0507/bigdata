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
        Schema::table('contracts', function (Blueprint $table) {
            $table->enum('status', [
                'new', 'accepted', 'picking', 'failed_to_pick', 'picked', 'shipping',
                'delivering', 'retry_delivery', 'delivered_successfully', 'pending', 'return_initiated',
                'returned', 'cancellation_requested', 'return_in_progress', 'continue_delivery',
                'shop_cancellation', 'vtp_cancellation', 'payment_successful', 'payment_pending', 'payment_cancelled'
            ])->default('new')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->enum('status', [
                'new', 'accepted', 'picking', 'failed_to_pick', 'picked', 'shipping',
                'delivering', 'retry_delivery', 'delivered_successfully', 'pending', 'return_initiated',
                'returned', 'cancellation_requested', 'return_in_progress', 'continue_delivery',
                'shop_cancellation', 'vtp_cancellation'
            ])->default('new')->change();
        });
    }
};
