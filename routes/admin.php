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
        Route::get('/transactions/{transaction}/confirm', [TransactionController::class, 'confirm'])
            ->name('transactions.confirm');
        Route::get('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])
            ->name('transactions.cancel');
        Route::get('/transactions/{transaction}/ship/edit', [TransactionController::class, 'editShip'])
            ->name('transactions.ship.edit');

        Route::post('/transactions/{transaction}/ship', [TransactionController::class, 'ship'])
            ->name('transactions.ship');
        Route::put('/transactions/{transaction}/ship/update', [TransactionController::class, 'updateShip'])
            ->name('transactions.ship.update');
    });
});
