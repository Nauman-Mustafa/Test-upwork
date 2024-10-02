<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4|confirmed',
            ]);

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hashing the password
            ]);

            // Optionally log the user in after registration
            // auth()->login($user);

            return response()->json(['message' => 'User registered successfully!'], 201);
        } catch (Exception $e) {
            // Handle any errors that occur during the registration process
            return response()->json(['message' => 'User registration failed!', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $user], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (Exception $e) {
            // Handle any errors that occur during the login process
            return response()->json(['message' => 'Login failed!', 'error' => $e->getMessage()], 500);
        }
    }
}
