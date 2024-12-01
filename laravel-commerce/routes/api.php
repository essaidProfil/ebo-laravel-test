<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


    // Routes API
    Route::get('/products', [ProductController::class, 'getProductsAction']);
    Route::get('/products/{product}', [ProductController::class, 'getProductAction']);
    Route::post('/products', [ProductController::class, 'postProductAction']);
    Route::put('/products/{product}', [ProductController::class, 'putProductAction']);
    Route::delete('/products/{product}', [ProductController::class, 'deleteProductAction']);

    Route::get('/categories/{categoryId}/products', [ProductController::class, 'getProductsByCategoryAction']);
