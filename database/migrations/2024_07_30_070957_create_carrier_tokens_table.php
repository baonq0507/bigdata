<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('carrier_name');
            $table->text('token'); // Token
            $table->dateTime('expires_at'); // Thời gian hết hạn của token
            $table->timestamps(); // Tự động thêm các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrier_tokens');
    }
}
