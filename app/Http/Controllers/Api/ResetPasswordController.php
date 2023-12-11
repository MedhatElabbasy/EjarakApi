<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed'],
            'password_confirmation'=> ['required'],
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $user = User::where('email',$request->email);
        $user->update([
            'password'=>Hash::make($request->password)
        ]);

        $token = $user->first()->createToken('authToken')->plainTextToken;

        return new JsonResponse(
            [
                'success' => true,
                'message' => "Your password has been reset",
                'token'=>$token
            ],
            200
        );
    }
}