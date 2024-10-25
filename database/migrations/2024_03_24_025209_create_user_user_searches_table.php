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
        Schema::create('user_user_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); // Người dùng thực hiện tìm kiếm
            $table->unsignedBigInteger('searched_user_id'); // Người dùng được tìm kiếm
            $table->timestamp('searched_at')->useCurrent(); // Thời gian tìm kiếm

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('searched_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_user_searches');
    }
};
