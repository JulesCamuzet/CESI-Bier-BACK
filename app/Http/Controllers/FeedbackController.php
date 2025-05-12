<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();
        return response()->json(data: $feedbacks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'rate' => 'required|integer|min:1|max:5',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);
        $feedback = Feedback::create($validated);
        return response()->json(data: $validated);
    }
}