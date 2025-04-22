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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->string('full_address'); 
            $table->float('total');
            $table->string('status'); 
            $table->date('purchase_date'); 
            $table->integer('quantity');
            $table->foreignId('promotion_code_id')->nullable()->constrained('promotion_codes')->onDelete('set null');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
