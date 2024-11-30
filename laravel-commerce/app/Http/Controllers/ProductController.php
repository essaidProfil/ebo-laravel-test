<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CateCategorygory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lister les produits
    public function getProductsAction(Request $request)
    {
        $query = Product::with('categories');

        // Recherche par nom ou description
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filtrer par catégorie
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Tri
        if ($request->has('sort')) {
            $query->orderBy($request->sort, $request->order ?? 'asc');
        }

        // Pagination
        return $query->paginate(10);
    }

    // Créer un produit
    public function postProductAction(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'description' => $request->input('description', null),
        ]);

        $product->categories()->attach($validated['categories']);

        return response()->json($product, 201);
    }

    // Mettre à jour un produit
    public function putProductAction(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product->update($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($validated['categories']);
        }

        return response()->json($product);
    }

    // Supprimer un produit
    public function deleteProductAction(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Le produit a été supprimé avec succes !'], 204);
    }

    // Voir un produit spécifique
    public function getProductAction(Product $product)
    {
        $product->load('categories');
        return response()->json($product);
    }
}
