<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [\App\Http\Controllers\API\V1\CategoryController::class, 'index']);
Route::get('/categories/{category}', [\App\Http\Controllers\API\V1\CategoryController::class, 'show']);
Route::get('/categories/{category}/get-filters', [\App\Http\Controllers\API\V1\CategoryController::class, 'getFilters']);

Route::post('/products', [\App\Http\Controllers\API\V1\ProductController::class, 'index']);
Route::get('/products/{product}', [\App\Http\Controllers\API\V1\ProductController::class, 'show']);
