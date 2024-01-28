<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    public function show(User $user)
    {
        return response()->json(['data' => $user]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            
        ]);
    
        $data['password'] = bcrypt($data['password']);
    
        $user = User::create($data);
    
        // Generate a token for the newly created user
        $token = $user->createToken('UserToken')->accessToken;
    
        return response()->json(['message' => 'User created successfully', 'data' => $user, 'access_token' => $token]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'data' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
