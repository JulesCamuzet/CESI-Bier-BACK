<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Connecté avec succès',
                    'user' => $request->user(),
                ]);
            }
            return redirect()->intended('dashboard');
        }
    
        $error = ['email' => 'Identifiants invalides.'];
    
        if ($request->wantsJson()) {
            return response()->json(['errors' => $error], 422);
        }
    
        return back()->withErrors($error)->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // le champ password_confirmation est attendu
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Inscription réussie',
                'user' => $user,
            ], 201);
        }

        return redirect()->intended('dashboard');
    }
    

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
