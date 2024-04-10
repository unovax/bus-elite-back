<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            //token en plaintext
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            $user = Auth::user();
            $user->token = $token;
            return response()->json(['user' => $user], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
