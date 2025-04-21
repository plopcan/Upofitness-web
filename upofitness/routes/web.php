<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\PromotionCodeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UsuarioController::class, 'login'])->name('login.submit');

Route::get('/usuario', function () {
    return view('usuario');
})->name('usuario');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('promotion-codes', PromotionCodeController::class);
Route::resource('payment-methods', PaymentMethodController::class);

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('productDiscount', ProductDiscountController::class);

Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');

Route::resource('usuarios', UsuarioController::class);
Route::resource('roles', RoleController::class);
Route::resource('carts', CartController::class);
Route::resource('addresses', AddressController::class);