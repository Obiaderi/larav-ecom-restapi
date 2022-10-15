<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        // return response(['message' => 'User created successfully']);
        
        $validate = $request->validate([
            'name' => 'required||max:191',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken($user->email.'_Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 200,
            'user' => $user,
            'message' => 'User created successfully'
        ]);
        
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);

        if (!auth()->attempt($validate)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials'
            ]);
        }

        $token = auth()->user()->createToken(auth()->user()->email.'_Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 200,
            'user' => auth()->user(),
            'message' => 'User logged in successfully'
        ]);
    }

    public function user()
    {
        return response()->json([
            'status' => 200,
            'user' => auth()->user(),
            'message' => 'User details'
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User logged out successfully'
        ]);
    }

}
