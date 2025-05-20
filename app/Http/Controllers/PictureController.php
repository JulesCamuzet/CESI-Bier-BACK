<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function index()
    {
        $orders = Picture::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'filename' => 'required|string|max:255',
        ]);
    
        $picture = Picture::create($validated);
    
        return response()->json($picture, 201);
    }
    

    public function show($id)
    {
        $order = Picture::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Picture::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'filename' => 'sometimes|required|string|max:255',
            'product_id' => 'sometimes|required|exists:product_id', 
          
        ]);
      
        $order->update($validated);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Picture::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
