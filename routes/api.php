<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

//Route::get('products', [ProductController::class, 'index']);
Route::resource('products', ProductController::class);

//Route::post('product/create', [ProductController::class, 'store']);