<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    /**
     * Affiche la liste des associations commande-produit.
     */
    public function index()
    {
        $orderProducts = OrderProduct::all();
        return response()->json($orderProducts);
    }

    /**
     * Crée une nouvelle association commande-produit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderProduct = OrderProduct::create($validated);

        return response()->json($orderProduct, 201);
    }

    /**
     * Affiche une association commande-produit spécifique.
     */
    public function show(string $id)
    {
        $orderProduct = OrderProduct::find($id);

        if (!$orderProduct) {
            return response()->json(['error' => 'OrderProduct not found'], 404);
        }

        return response()->json($orderProduct);
    }

    /**
     * Met à jour une association commande-produit existante.
     */
    public function update(Request $request, string $id)
    {
        $orderProduct = OrderProduct::find($id);

        if (!$orderProduct) {
            return response()->json(['error' => 'OrderProduct not found'], 404);
        }

        $validated = $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        $orderProduct->update($validated);

        return response()->json($orderProduct);
    }

    /**
     * Supprime une association commande-produit.
     */
    public function destroy(string $id)
    {
        $orderProduct = OrderProduct::find($id);

        if (!$orderProduct) {
            return response()->json(['error' => 'OrderProduct not found'], 404);
        }

        $orderProduct->delete();

        return response()->json(['message' => 'OrderProduct deleted successfully']);
    }
}
