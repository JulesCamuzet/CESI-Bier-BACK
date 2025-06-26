<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    
    public function index()
    {
        $feedbacks = Feedback::all();
        return response()->json($feedbacks);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rate' => 'required|integer|min:1|max:5',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $feedback = Feedback::create($validated);

        return response()->json($feedback, 201);
    }

  
    public function show(string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        return response()->json($feedback);
    }

 
    public function update(Request $request, string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'rate' => 'sometimes|integer|min:1|max:5',
            'user_id' => 'sometimes|exists:users,id',
            'product_id' => 'sometimes|exists:products,id',
        ]);

        $feedback->update($validated);

        return response()->json($feedback);
    }

 
    public function destroy(string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully']);
    }


    public function getFeedbacks(string $product_id)
    {
        $feedbacks = Feedback::where('product_id', $product_id)->get();
    
        if ($feedbacks->isEmpty()) {
            return response()->json([], 200);
        }
    
        return response()->json($feedbacks);
    }
}
