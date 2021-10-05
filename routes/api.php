<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;

Route::group(['prefix' => 'v1'], function(){
    Route::resource('products', ProductController::class);
});

Route::group(['prefix' => 'v2'], function(){
    Route::resource('products', ProductController::class);
});