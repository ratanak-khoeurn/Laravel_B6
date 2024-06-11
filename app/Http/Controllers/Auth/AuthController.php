<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response([
                'message' => 'Validation errors',
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
        return response([
            'message' => 'User created successfully',
            'success' => true,
            'user' => $user,
        ]);
    }
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response([
                'message' => 'Validation errors',
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => 'User not found!',
                'success' => false
            ]);
        }

        // Check if the provided password matches the user's password
        if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid credentials!',
                'success' => false
            ]);
        }

        // Create an access token for the user
        $access_token = $user->createToken('authToken')->plainTextToken;

        // Return success response
        return response([
            'message' => 'User logged in successfully',
            'success' => true,
            'user' => $user,
            'token' => $access_token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
           'message' => 'User logout success fully'
        ],200);
    }
}
