<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation email et mot de passe
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Chercher l'utilisateur
        $user = User::where('email', $validated['email'])->first();

        // Verifier l'existance de l'utilisateur et la validite du mot de passe
        if (!$user || !\Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Creation du token pour l'utilisateur authentifié
        $token = $user->createToken('ProductAppToken')->plainTextToken;

        // Retourner le Token
        return response()->json(['token' => $token], 200);
    }
}
