<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
/** 
* @OA\Post(
*  path="/auth/user",
*  summary="user data",
*  description="",
*  tags={"User"},
*  @OA\Parameter(
*      name="name",
*      in="query",
*      description="Provide your name",
*      required=true,
*  ),
*  @OA\Response(
*      response=200,
*      description="OK",
*      @OA\MediaType(
*          mediaType="application/json",
*      )
*   ),
* )
*/

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users/list",
     *     summary="List all users",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();
        return response(['success' => true, 'data' => $users], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $user_exist = User::where('email', $request->email)->first();
        if ($user_exist) {
            return response([
                'message' => 'User already exist !',
                'success' => false
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response([
            'message' => 'User created successfully',
            'success' => true,
            'user' => $user
        ], 200);
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

    public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'User has been logged out successfully'
    ], 200);
}
}
