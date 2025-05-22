<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($user->is_admin) {
            $orders = Order::all();
        } else {
            $orders = Order::where('user_id', $user->id)->get();
        }

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'total_cost' => 'required|numeric',
            'payment_key' => 'nullable|string|max:255',
            'adress' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ]);

        $order = Order::create($validated);
        return response()->json($order, 201);
    }


    public function place_order(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'adress' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $totalCost = 0;

            // Vérifier stock et calculer total
            foreach ($data['products'] as $item) {
                $product = Product::findOrFail($item['id']);
                if ($product->stock < $item['quantity']) {
                    return response()->json(['error' => "Stock insuffisant pour le produit {$product->name}"], 400);
                }
                $totalCost += $item['price'] * $item['quantity'];
            }

            // Créer la commande
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_cost = $totalCost;
            $order->status = 'pending';
            $order->adress = $data['adress'];
            $order->zip_code = $data['zip_code'];
            $order->city = $data['city'];
            $order->country = $data['country'];
            $order->payment_key = '';
            $order->payment_url = '';
            $order->save();

            // Insérer dans order_item sans le prix
            foreach ($data['products'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // Décompter le stock
            foreach ($data['products'] as $item) {
                $product = Product::findOrFail($item['id']);
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Création session Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $lineItems = [];
            foreach ($data['products'] as $item) {
                $unitAmount = intval($item['price'] * 100); // centimes

                $product = Product::findOrFail($item['id']);
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => ['name' => $product->name],
                        'unit_amount' => $unitAmount,
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => env('FRONT_URL') . '/reussi',
                'cancel_url' => env('FRONT_URL') . '/cancel',
                'metadata' => ['order_id' => $order->id],
            ]);

            $order->payment_key = $session->id;
            $order->payment_url = $session->url;
            $order->save();

            DB::commit();

            return response()->json(['url' => $session->url]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erreur lors de la création de la commande',
                'details' => $e->getMessage(),
            ], 500);
        }
    }



    public function show($id)
    {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $order = Order::with('products')->find($id);
    
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    
        if ($user->is_admin || $order->user_id === $user->id) {
            $orderData = $order->toArray();
    
            $orderData['products'] = collect($order->products)->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,  
                ];
            });
    
            return response()->json($orderData);
        }
    
        return response()->json(['error' => 'Forbidden'], 403);
    }
    



    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|required|string|max:255',
            'total_cost' => 'sometimes|required|numeric',
            'payment_key' => 'nullable|string|max:255',
            'adress' => 'sometimes|required|string|max:255',
            'zip_code' => 'sometimes|required|string|max:20',
            'city' => 'sometimes|required|string|max:100',
            'country' => 'sometimes|required|string|max:100',
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
