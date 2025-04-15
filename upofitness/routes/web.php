<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('promotion-codes', PromotionCodeController::class);
Route::resource('payment-methods', PaymentMethodController::class);

