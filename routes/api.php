<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;




Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {});

    Route::get('/me', [UserController::class, 'me']);
    Route::get('/users', [UserController::class, 'index']);
//categories
    Route::get('categories', [CategoryController::class, 'getAll']);
    Route::post('categories', [CategoryController::class, 'save']);
    Route::get('categories/{id}', [CategoryController::class, 'get']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
//products
    Route::get('products', [ProductController::class, 'getAll']);
    Route::post('products', [ProductController::class, 'save']);
    Route::get('products/{id}', [ProductController::class, 'get']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

