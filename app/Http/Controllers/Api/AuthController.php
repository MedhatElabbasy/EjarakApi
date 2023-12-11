<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Twilio\Rest\Client;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendVerificationAuthEmail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => ['required', 'confirmed'],
            'password_confirmation'=> ['required'],
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

        // $this->sendVerificationCode($user);
        // $user->sendPhoneVerificationNotification();


        if ($user) {
            $verify2 =  DB::table('password_resets')->where([
                ['email', $request->all()['email']]
            ]);

            if ($verify2->exists()) {
                $verify2->delete();
            }
            $pin = rand(100000, 999999);
            DB::table('password_resets')
                ->insert(
                    [
                        'email' => $request->all()['email'],
                        'token' => $pin
                    ]
                );
        }
        // SendVerificationAuthEmail::dispatch($user, $pin);
        Mail::to($request->email)->send(new VerifyEmail($pin));

        $token = $user->createToken('authToken')->plainTextToken;


        return response()->json(['message' => 'User registered successfully.', 'user' => $user,'token'=> $token ], 201);
    }


    //login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required_without:phone|string',
            'phone' => 'sometimes|required_without:email|string',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::where('phone', $request->phone)->first();
        }

        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token, 'message' => 'Login successful']);
        } else {

            return response()->json(['error' => 'Invalid credentials'], 401);
        }

    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }





    // protected function sendVerificationCode(User $user)
    // {
    //     $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'), env('TWILIO_PHONE_NUMBER'));

    //     $verificationCode = mt_rand(100000, 999999);

    //     $user->update(['verification_code' => $verificationCode]);

    //     $twilio->messages->create(
    //         $user->phone,
    //         [
    //             'from' => env('TWILIO_PHONE_NUMBER'),
    //             'body' => "Your verification code is: $verificationCode",
    //         ]
    //     );
    // }

}