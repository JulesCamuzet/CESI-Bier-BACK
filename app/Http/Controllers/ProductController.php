<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

   
    public function store(Request $request)
{
    // Valider les données reçues
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'picture' => 'nullable|url',
        'status' => 'required|in:disponible,indisponible',
        'supplier_id' => 'required|exists:suppliers,id',
        'category_id' => 'required|exists:categories,id',
    ]);

    // Créer un nouveau produit
    $product = Product::create($validated);

    // Retourner une réponse JSON avec le nouveau produit et un code 201 (créé)
    return response()->json($product, 201);
}

    
    

    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

 
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'picture' => 'nullable|url', 
            'status' => 'sometimes|required|in:disponible,indisponible',
            'supplier_id' => 'sometimes|required|exists:suppliers,id', 
            'category_id' => 'sometimes|required|exists:categories,id', 
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update($validated);

        return response()->json($product);
    }

  
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
