<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->except('show');
    Route::patch('categories/{category}/update-attributes', [\App\Http\Controllers\CategoryController::class, 'updateAttributes'])
        ->name('categories.update.attributes');

    Route::resource('attributes', \App\Http\Controllers\AttributeController::class)
        ->except(['show', 'create', 'edit']);

    Route::resource('measure-units', \App\Http\Controllers\MeasureUnitController::class)
        ->except(['show', 'create', 'edit']);

    Route::resource('products', \App\Http\Controllers\ProductController::class)
        ->except('show');
    Route::patch('products/{product}/update-attributes', [\App\Http\Controllers\ProductController::class, 'updateAttributes'])
        ->name('products.update.attributes');
});

require __DIR__ . '/auth.php';
