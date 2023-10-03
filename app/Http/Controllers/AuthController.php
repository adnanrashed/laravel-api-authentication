<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
   

// ...

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (\App\Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('UserToken')->accessToken;

        return response()->json(['message' => 'Login successful', 'user' => $user, 'access_token' => $token]);
    } else {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

}
