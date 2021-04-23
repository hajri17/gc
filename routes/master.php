<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::resource('items', \App\Http\Controllers\ItemController::class);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    });
});
