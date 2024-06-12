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
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => 'User Not Found!',
                'success' => false
            ], 400);
        }
        if (Hash::check($request->password, $user->password)) {
            $access_token = $user->createToken('authToken')->plainTextToken;
            return response([
                'message' => 'Login successfully',
                'success' => true,
                'user' => $user,
                'access_token' => $access_token
            ], 200);
        } else {
            return response([
                'message' => 'Invalid Password!',
                'success' => false
            ], 400);
        }
    }
}
