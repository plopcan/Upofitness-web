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
        // Ensure 'usuarios' table exists before adding foreign keys
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('role_id', 'usuarios_role_id_foreign')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('image_id', 'usuarios_image_id_fk')->references('id')->on('images')->onDelete('set null');
        });

        // Add foreign keys for 'addresses' table
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('usuario_id', 'addresses_usuario_id_fk')->references('id')->on('usuarios')->onDelete('cascade');
        });

        // Add foreign keys for 'payment_methods' table
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreign('usuario_id', 'payment_methods_usuario_id_fk')->references('id')->on('usuarios')->onDelete('cascade');
        });

        // Add foreign keys for 'wishlists' table
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('usuario_id', 'wishlists_usuario_id_fk')->references('id')->on('usuarios')->onDelete('cascade');
        });

        // Add foreign keys for 'carts' table
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('usuario_id', 'carts_usuario_id_fk')->references('id')->on('usuarios')->onDelete('cascade');
        });

        // Add foreign keys for 'cart_product' table
        Schema::table('cart_product', function (Blueprint $table) {
            $table->foreign('cart_id', 'cart_product_cart_id_fk')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id', 'cart_product_product_id_fk')->references('id')->on('products')->onDelete('cascade');
        });

        // Add foreign keys for 'product_discounts' table
        Schema::table('product_discounts', function (Blueprint $table) {
            $table->foreign('product_id', 'product_discounts_product_id_fk')->references('id')->on('products')->onDelete('cascade');
        });

        // Add foreign keys for 'payments' table
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('orders_id', 'payments_orders_id_fk')->references('id')->on('orders')->onDelete('cascade');
        });

        // Add foreign keys for 'invoices' table
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('orders_id', 'invoices_orders_id_fk')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_role_id_foreign');
            $table->dropForeign('usuarios_image_id_fk');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_usuario_id_fk');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('payment_methods_usuario_id_fk');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign('wishlists_usuario_id_fk');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_usuario_id_fk');
        });

        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropForeign('cart_product_cart_id_fk');
            $table->dropForeign('cart_product_product_id_fk');
        });

        Schema::table('product_discounts', function (Blueprint $table) {
            $table->dropForeign('product_discounts_product_id_fk');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_orders_id_fk');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_orders_id_fk');
        });
    }
};
