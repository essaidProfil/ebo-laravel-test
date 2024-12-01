<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Lister les produits
    public function getProductsAction(Request $request)
    {
        $query = Product::with('categories');

        // Recherche par nom ou description
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('price', '=', $request->search); // Exact match for price//
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
        // Custom validation rules and messages
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ], [
            'name.required' => 'Le nom du produit est un champ requis !',
            'name.max' => 'Le nom du produit ne doit pas depasser les 255 characters !',
            'price.required' => 'Le champ prix est requis !',
            'price.numeric' => 'Le prix doit contenir des chiffres uniquement !',
            'price.min' => 'Le prix ne doit pas être en négatif !',
            'stock.integer' => 'Le champ stock doit contenir des chiffres uniquement !',
            'stock.min' => 'Le champ stock doit contenir QTT 1 et plus !',
            'categories.required' => 'Une categorie est requise au minimum',
            'categories.array' => 'Les categories doivent être mises dans les crochet []',
            'categories.*.exists' => 'La category doit être enregistrer dans la base de données !',
        ]);

        // Verifier si les validations ne passent pas
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity response
        }

        // Si la validation passe creer le produit
        $validated = $validator->validated();
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'description' => $request->input('description', null),
        ]);

        // Attacher les categories au produit
        $product->categories()->attach($validated['categories']);

        // Retourner une reponse de validation avec succes
        return response()->json($product, 201);
    }

    // Mettre à jour un produit
    public function putProductAction(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|max:255',
            'description' => 'sometimes|required|max:355',
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
        $productName = $product->name;  // Get the product name
        $product->delete();

        // Return a JSON response with the product name and success message
        return response()->json([
            'message' => 'Le produit ' . $productName . ' a été supprimé avec succès !'
        ], 200);
    }

    // Voir un produit spécifique
    public function getProductAction(Product $product)
    {
        $product->load('categories');
        return response()->json($product);
    }

    /**
     * Liste les produits par catégorie.
     *
     * @param  int  $categoryId
     * @return JsonResponse
     */
    public function getProductsByCategoryAction($categoryId)
    {
        // Vérifiez si la catégorie existe
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Récupérer les produits de cette catégorie
        $products = $category->products;

        return response()->json([
            'category' => $category->name,
            'products' => $products,
        ], 200);
    }
}
