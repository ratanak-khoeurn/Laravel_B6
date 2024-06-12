<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    public function forgotpassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email'       
        ]);
        $statu = Password::sendResetLink(
            $request ->only('email')
        );
        if ($statu == Password::RESET_LINK_SENT){
            return[
                'statu'=> __($statu)
            ];
        }
        throw ValidationException::withMessages([
            'email' => [trans($statu)]
        ]);
    }
}
