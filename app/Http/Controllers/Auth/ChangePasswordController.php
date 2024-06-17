<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Get the authenticated user
        $user = $request->user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated!',
            ], 401);
        }

        // Check if the old password matches
        if (Hash::check($request->old_password, $user->password)) {
            // Update the user's password
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Password changed successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Old password does not match!',
            ], 400);
        }
    }
}
