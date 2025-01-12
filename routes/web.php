<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
