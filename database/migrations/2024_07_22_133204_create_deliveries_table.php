<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('contract_id');
            $table->string('package_image')->nullable();
            $table->decimal('product_length', 8, 2);
            $table->decimal('product_width', 8, 2)->nullable();
            $table->decimal('product_height', 8, 2)->nullable();
            $table->decimal('product_weight', 8, 2);
            $table->string('product_note')->nullable();
            $table->json('delivery_user_a_info');
            $table->json('delivery_user_b_info');
            $table->json('list_products');
            $table->bigInteger('money_total_ship');
            $table->text('order_note')->nullable();
            $table->string('order_service');
            $table->string('order_service_add');
            $table->enum('status', [
                'picking_up',            // Đang lấy hàng
                'picked_up',             // Đã lấy hàng
                'in_transit',            // Đang vận chuyển
                'delivering',            // Đang giao hàng
                'awaiting_redelivery',   // Chờ phát lại
                'successfully_delivered',// Giang thành công
                'awaiting_processing',   // Chờ xử lý
                'return_approved',       // Đã duyệt hoàn
                'returned',              // Đã trả
                'delivery_cancelled',    // Đã huỷ giao
                'returning',             // Đang chuyển hoàn
                'continue_delivery',     // Phát tiếp
                'shop_cancelled_pickup', // Shop huỷ lấy
                'vtp_cancelled_pickup'   // VTP huỷ lấy
            ])->default('awaiting_processing');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
