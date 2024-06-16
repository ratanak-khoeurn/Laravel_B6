<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class NewPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset password link sent to your email.']);
        } else {
            return response()->json(['error' => 'Unable to send reset password link.'], 500);
        }
    }

    protected function broker()
    {
        return Password::broker();
    }
}
