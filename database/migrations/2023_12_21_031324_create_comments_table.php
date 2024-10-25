<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->enum('status',['active','block','pending'])->default('active');
            $table->timestamps();

            // Ràng buộc khóa ngoại cho post_id
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            // Ràng buộc khóa ngoại cho user_id
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Xóa ràng buộc khóa ngoại trước khi xóa bảng
            $table->dropForeign(['post_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('comments');
    }
};
