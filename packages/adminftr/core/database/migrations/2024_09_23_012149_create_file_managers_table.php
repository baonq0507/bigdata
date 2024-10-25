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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');         // Tên file
            $table->string('file_path');         // Đường dẫn lưu file
            $table->string('folder_path')->nullable(); // Đường dẫn thư mục chứa file
            $table->unsignedBigInteger('user_id')->nullable(); // ID người dùng upload (nếu có)
            $table->string('file_type');         // Loại file, ví dụ: image, document
            $table->bigInteger('file_size');     // Kích thước file
            $table->text('description')->nullable(); // Mô tả file
            $table->string('tags')->nullable();  // Tags của file
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Khóa ngoại tham chiếu đến bảng users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};
