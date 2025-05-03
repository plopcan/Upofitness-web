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
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WishlistController;
use App\Models\PromotionCode;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UsuarioController::class, 'authenticate'])->name('login.submit');

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth')->name('admin');

#Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
#Route::resource('invoices', InvoiceController::class);
Route::resource('promotion-codes', PromotionCodeController::class);
Route::resource('payment-methods', PaymentMethodController::class);

Route::get('/products/filter', [ProductController::class, 'filterByCategory'])->name('products.filterByCategory');
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('productDiscount', ProductDiscountController::class);

Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
Route::post('/products/{product}/images', [ImageController::class, 'store'])->name('products.images.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::resource('roles', RoleController::class);
Route::resource('carts', CartController::class);
Route::resource('addresses', AddressController::class);

Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
Route::get('/cart/user/{id}', [CartController::class, 'showByUserId'])->name('cart.showByUserId');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Ruta para validar y aplicar código promocional
Route::post('/cart/apply-promo', [CartController::class, 'applyPromoCode'])->name('cart.apply-promo');

Route::resource('products.images', App\Http\Controllers\ImageController::class);
Route::post('/products/{product}/images/multiple', [App\Http\Controllers\ImageController::class, 'storeMultiple'])
    ->name('products.images.storeMultiple');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update-quantity/{productId}/{action}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::get('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'showByUserId'])->name('wishlist.showByUserId');
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::post('/wishlist/clear', [WishlistController::class, 'clearWishlist'])->name('wishlist.clear');

Route::get('/register', [UsuarioController::class, 'create'])->name('register'); 
Route::post('/register', [UsuarioController::class, 'store'])->name('register.submit'); 

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [UsuarioController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UsuarioController::class, 'update'])->name('profile.update');
    Route::get('/orders/user/{id}', [OrderController::class, 'showByUserId'])->name('orders.showByUserId');
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/usuarios/manage', [UsuarioController::class, 'index'])->name('usuarios.manage');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::post('/usuarios/{id}/update', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::get('/admin/usuarios/manage', [UsuarioController::class, 'index'])->name('admin.manage');
    Route::get('/admin/usuarios/{usuario}/edit', [UsuarioController::class, 'adminEdit'])->name('admin.usuarios.edit');
    Route::post('/admin/usuarios/{usuario}/update', [UsuarioController::class, 'adminUpdate'])->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

Route::post('/language/change', [LanguageController::class, 'change'])->name('language.change');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('auth.forgot-password');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


