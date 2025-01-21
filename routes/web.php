<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('attributes', \App\Http\Controllers\AttributeController::class)
        ->except('show');
    Route::resource('measure-units', \App\Http\Controllers\MeasureUnitController::class)
        ->except(['show', 'create', 'edit']);
});

require __DIR__ . '/auth.php';
