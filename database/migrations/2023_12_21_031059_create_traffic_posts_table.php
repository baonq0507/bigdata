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
        Schema::create('traffic_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('ip')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['view', 'like', 'share'])->default('view');
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_posts');
    }
};
