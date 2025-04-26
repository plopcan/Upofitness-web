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
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WishlistController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UsuarioController::class, 'authenticate'])->name('login.submit');

Route::get('/usuario', function () {
    return view('usuario');
})->middleware('auth')->name('usuario'); 

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth')->name('admin');

Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('promotion-codes', PromotionCodeController::class);
Route::resource('payment-methods', PaymentMethodController::class);

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('productDiscount', ProductDiscountController::class);

Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
Route::get('/products/category/{categoryId}', [ProductController::class, 'filterByCategory'])->name('products.filterByCategory');
Route::post('/products/{product}/images', [ImageController::class, 'store'])->name('products.images.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::resource('usuarios', UsuarioController::class);
Route::resource('roles', RoleController::class);
Route::resource('carts', CartController::class);
Route::resource('addresses', AddressController::class);

Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
Route::get('/cart/user/{id}', [CartController::class, 'showByUserId'])->name('cart.showByUserId');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::resource('products.images', App\Http\Controllers\ImageController::class);
Route::post('/products/{product}/images/multiple', [App\Http\Controllers\ImageController::class, 'storeMultiple'])
    ->name('products.images.storeMultiple');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'showByUserId'])->name('wishlist.showByUserId');
Route::post('/wishlist/add/{productId}', [App\Http\Controllers\WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{productId}', [App\Http\Controllers\WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::post('/wishlist/clear', [App\Http\Controllers\WishlistController::class, 'clearWishlist'])->name('wishlist.clear');
