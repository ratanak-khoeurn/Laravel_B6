<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'profession' => 'nullable|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,bmp,png'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validations fails',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                $old_path = public_path() . '/uploads/profile_images/' . $user->profile_photo;
                if (File::exists($old_path)) {
                    File::delete($old_path);
                }
            }

            $image_name = 'profile-image-' . time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('/uploads/profile_images'), $image_name);
        } else {
            $image_name = $user->profile_photo;
        }


        $user->update([
            'name' => $request->name,
            'profession' => $request->profession,
            'profile_photo' => $image_name
        ]);

        return response()->json([
            'message' => 'Profile successfully updated',
        ], 200);


    }

    public function view_profile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'name' => $user->name,
            'profession' => $user->profession,
            'profile_photo' => $user->profile_photo,
        ], 200);
    }
}
