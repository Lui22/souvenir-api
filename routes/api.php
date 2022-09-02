<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\UserController;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('signup', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('products', [ProductController::class, 'index']);

Route::middleware('auth:api')->group(function () {
	Route::get('logout', [UserController::class, 'logout']);


	Route::middleware('role:client')->group(function () {
		Route::get('cart', [ProductUserController::class, 'index']);
		Route::post('cart/{product_id}', [ProductUserController::class, 'store']);
		Route::delete('cart/{productUser}', [ProductUserController::class, 'destroy']);

		Route::post('order', [OrderController::class, 'store']);
		Route::get('order', [OrderController::class, 'index']);
	});

	Route::middleware('role:admin')->group(function () {
		Route::post('product', [ProductController::class, 'store']);
		Route::patch('product/{product}', [ProductController::class, 'update']);
		Route::delete('product/{product}', [ProductController::class, 'destroy']);
	});
});

Route::any('{any}', [Controller::class, 'notFound']);
