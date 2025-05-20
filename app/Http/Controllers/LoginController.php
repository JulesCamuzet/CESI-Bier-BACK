<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
