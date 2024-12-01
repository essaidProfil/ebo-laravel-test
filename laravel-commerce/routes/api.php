<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\RequestStatMiddleware;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);

// Routes sécurisées (authentification requise)
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes Produits
    Route::prefix('product')->middleware(RequestStatMiddleware::class)->group(function () {
        Route::post('/', [ProductController::class, 'postProductAction']);
        Route::put('/{product}', [ProductController::class, 'putProductAction']);
        Route::delete('/{product}', [ProductController::class, 'deleteProductAction']);
    });

    // Statistiques
    Route::get('/stats', function () {
        $stats = \App\Models\RequestStat::all();
        return response()->json($stats);
    });
});

// Routes publiques (sans authentification)
// Les statistiques des API requests de ces ROUTES sont enregistrés dans une table "request_stats"
// Todo refaire cette methode et utiliser une declaration du middleware dans Kernel
Route::middleware([RequestStatMiddleware::class])->group(function () {
    // Routes Produits
    Route::get('/products', [ProductController::class, 'getProductsAction']);
    Route::get('/products/{product}', [ProductController::class, 'getProductAction']);
    Route::get('/category/{categoryId}/products', [ProductController::class, 'getProductsByCategoryAction']);
});
