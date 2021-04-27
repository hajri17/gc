<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::name('admin.')->prefix('admin')->group(function () {
        Route::resource('items', ItemController::class);
        Route::resource('categories', CategoryController::class);

        Route::resource('transactions', TransactionController::class);
        Route::get('/transactions/{transaction}/paid', [TransactionController::class, 'paid'])
            ->name('transactions.paid');
        Route::get('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])
            ->name('transactions.cancel');
    });
});
