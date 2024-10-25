<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingCodeToDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->string('shipping_code')->after('status')->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('shipping_code');
        });
    }
}
