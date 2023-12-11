<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => 3,
            'password' => Hash::make($request->password),

        ]);

        $this->sendVerificationCode($user);
        $user->sendPhoneVerificationNotification();

        return response()->json(['message' => 'User registered successfully.'], 201);
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        if ($user->verification_code !== $request->code) {
            return response()->json(['error' => 'Invalid verification code.'], 422);
        }

        $user->update([
            'phone_verified_at' => now(),
        ]);

        return response()->json(['message' => 'Phone number verified successfully.']);
    }

    protected function sendVerificationCode(User $user)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'),env('TWILIO_PHONE_NUMBER'));

        $verificationCode = mt_rand(100000, 999999);

        $user->update(['verification_code' => $verificationCode]);

        $twilio->messages->create(
            $user->phone,
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => "Your verification code is: $verificationCode",
            ]
        );
    }

public function  login(){


}

}