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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('role_id', 'usuarios_role_id_foreign')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('image_id', 'usuarios_image_id_fk')->references('id')->on('images')->onDelete('set null'); // FK for image_id in usuarios
        });

        Schema::table('images', function (Blueprint $table) {
            // Remove the FK definition for product_id here to avoid duplication
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });

        Schema::table('cart_product', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('product_discounts', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['image_id']);
        });

        Schema::table('images', function (Blueprint $table) {
            // No need to drop the FK for product_id here as it was never created
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });

        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('product_discounts', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['orders_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['orders_id']);
        });
    }
};
