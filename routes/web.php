<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', \App\Http\Controllers\UserController::class)
        ->except('create', 'store', 'show');
    Route::post('users/{userId}/restore', [\App\Http\Controllers\UserController::class, 'restore'])
        ->name('users.restore');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->except('show');
    Route::patch('categories/{category}/update-attributes', [\App\Http\Controllers\CategoryController::class, 'updateAttributes'])
        ->name('categories.update_attributes');

    Route::resource('attributes', \App\Http\Controllers\AttributeController::class)
        ->except(['show', 'create', 'edit']);

    Route::resource('measure-units', \App\Http\Controllers\MeasureUnitController::class)
        ->except(['show', 'create', 'edit']);

    Route::resource('products', \App\Http\Controllers\ProductController::class)
        ->except('show');
    Route::patch('products/{product}/update-attributes', [\App\Http\Controllers\ProductController::class, 'updateAttributes'])
        ->name('products.update_attributes');

    Route::resource('orders', \App\Http\Controllers\OrderController::class)
        ->except('show', 'create', 'store');
    Route::post('orders/{orderId}/restore', [\App\Http\Controllers\OrderController::class, 'restore'])
        ->name('orders.restore');
});

require __DIR__ . '/auth.php';
