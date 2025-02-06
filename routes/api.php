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
    Route::post('/users/registerClient', [AuthController::class, 'registerClient']);
//categories
    Route::get('categories/all', [CategoryController::class, 'getAll']);
    Route::post('categories/save', [CategoryController::class, 'save']);
    Route::get('categories/get/{id}', [CategoryController::class, 'get']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('categories/add', [CategoryController::class, 'add']);
//products
    Route::get('products/all', [ProductController::class, 'getAll']);
    Route::post('products/save', [ProductController::class, 'save']);
    Route::get('products/get/{id}', [ProductController::class, 'get']);
    Route::delete('products/delete/{id}', [ProductController::class, 'destroy']);

