<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->json('sizes')->nullable();     // ["S","M","L","XL"]
            $table->json('colors')->nullable();    // ["Negro","Blanco","Azul"]
            $table->string('category');            // Camisetas, Pantalones, etc
            $table->string('brand');
            $table->integer('stock')->default(0);
            $table->json('reviews')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};