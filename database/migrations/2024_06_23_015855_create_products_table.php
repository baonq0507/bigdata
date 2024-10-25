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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('field', ['leather_goods', 'clothing']);
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('color');
            $table->string('quantity');
            $table->string('price');
            $table->enum('gender',[
                'male','female'
            ]);
            $table->json('size')->nullable();
            $table->string('material');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
