<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return response()->json(User::all(), 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }

    public function me()
    {
        $user = Auth::user();
        return response()->json($user);
    }


    public function show(string $id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() != $user->id) {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        return response()->json($user);
    }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|string',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        if (auth()->id() != $user->id && !auth()->user()->is_admin) {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        $user->update($validated);

        return response()->json($user);
    }


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (auth()->id() != $user->id && !auth()->user()->is_admin) {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        return response()->json(['message' => 'Utilisateur supprimé.']);
    }
}
