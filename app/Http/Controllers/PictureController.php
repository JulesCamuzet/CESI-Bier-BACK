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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'pictures' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048', // max 2MB
        ]);
    
        if ($request->hasFile('pictures')) {
            $file = $request->file('pictures');
            $filename = time() . '_' . $file->getClientOriginalName();
    
            $path = $file->storeAs('public/pictures', $filename);
    
            $picture = Picture::create([
                'product_id' => $request->product_id,
                'filename' => $filename,
            ]);
    
            return response()->json([
                'message' => 'Image uploaded successfully',
                'filename' => $filename,
                'url' => asset('storage/pictures/' . $filename),
            ]);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
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
