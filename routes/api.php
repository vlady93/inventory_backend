<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;




Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    Route::get('/me', [UserController::class, 'me']);
    Route::get('/users', [UserController::class, 'index']);
//categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
//products
Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/poleras', [ProductController::class, 'getProduct']);
Route::post('/send-email', [ProductController::class, 'sendEmail']);
});
