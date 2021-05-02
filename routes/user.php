<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::name('user.auth.')->group(function () {
        Route::get('login', [\App\Http\Controllers\User\LoginController::class, 'index'])
            ->name('index');

        Route::post('auth/login', [\App\Http\Controllers\User\LoginController::class, 'login'])
            ->name('login');
        Route::post('auth/register', [\App\Http\Controllers\User\RegisterController::class, 'register'])
            ->name('register');
    });
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/quick-view', [ProductController::class, 'quickView'])->name('products.quick');
Route::get('/products/{id}/fullscreen', [ProductController::class, 'fullScreen'])->name('products.fullscreen');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::middleware('auth')->group(function () {
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    Route::get('/checkouts', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/review/{transaction}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{transaction}', [ReviewController::class, 'store'])->name('review.store');

    Route::post('/transaction/{transaction}/confirm', [TransactionController::class, 'confirm'])->name('transaction.confirm');
    Route::post('/transaction/{transaction}/accept', [TransactionController::class, 'accept'])->name('transaction.accept');
});

