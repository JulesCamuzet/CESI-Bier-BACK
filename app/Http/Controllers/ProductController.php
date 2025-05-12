<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les produits
        $products = Product::all();

        // Retourner les produits sous forme de réponse JSON
        return response()->json($products);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'picture' => 'nullable|url', 
            'status' => 'required|in:disponible,indisponible',
            'supplier_id' => 'required|exists:suppliers,id', 
            'category_id' => 'required|exists:categories,id', 
            
        ]);

        // Création du produit avec les données validées
        $product = Product::create($validated);

        // Retourner la réponse JSON avec le produit créé
        return response()->json($product, 201); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupérer le produit par ID
        $product = Product::find($id);

        if (!$product) {
            // Si le produit n'existe pas, retourner une erreur 404
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Retourner le produit sous forme de réponse JSON
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'picture' => 'nullable|url', // Ajout de la validation pour la picture
            'status' => 'sometimes|required|in:disponible,indisponible',
            'supplier_id' => 'sometimes|required|exists:suppliers,id', // Validation du supplier_id
            'category_id' => 'sometimes|required|exists:categories,id', // Validation du category_id
        ]);

        // Récupérer le produit par ID
        $product = Product::find($id);

        if (!$product) {
            // Si le produit n'existe pas, retourner une erreur 404
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Mettre à jour les informations du produit
        $product->update($validated);

        // Retourner la réponse JSON avec le produit mis à jour
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer le produit par ID
        $product = Product::find($id);

        if (!$product) {
            // Si le produit n'existe pas, retourner une erreur 404
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Supprimer le produit
        $product->delete();

        // Retourner une réponse de succès
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
