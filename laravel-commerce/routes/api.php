<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'getProductsAction']); // Récuperer tous les products
    Route::get('/products/{product}', [ProductController::class, 'getProductAction']); // Récuperer un produi par identifiant
    Route::post('/products', [ProductController::class, 'postProductAction']); // Ajouter des produits
    Route::put('/products/{product}', [ProductController::class, 'putProductAction']);
    Route::delete('/products/{product}', [ProductController::class, 'deleteProductAction']);

    // Get products by category
    Route::get('/categories/{categoryId}/products', [ProductController::class, 'getProductsByCategoryAction']);
});
