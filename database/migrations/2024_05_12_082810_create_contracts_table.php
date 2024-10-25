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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('invoice_image')->nullable();
            $table->string('product_image')->nullable();
            $table->string('description')->nullable();
            $table->decimal('total_amount', 20, 2); // Updated to handle larger sums
            $table->decimal('deposit_amount', 20, 2); // Updated to handle larger sums
            $table->boolean('confirmation_a')->default(false);
            $table->boolean('confirmation_b')->default(false);
            $table->boolean('confirmation_c')->default(false);
            $table->boolean('terms_agreed')->default(false); // Added this line
            $table->enum('status', [
                'new', 'accepted', 'picking', 'failed_to_pick', 'picked', 'shipping',
                'delivering', 'retry_delivery', 'delivered_successfully', 'pending', 'return_initiated',
                'returned', 'cancellation_requested', 'return_in_progress', 'continue_delivery',
                'shop_cancellation', 'vtp_cancellation'
            ])->default('new');
            $table->date('estimated_delivery_date')->nullable();
            $table->unsignedBigInteger('id_party_b_info')->nullable();
            $table->unsignedBigInteger('id_party_a_info');
            $table->bigInteger('id_user_b');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
