<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return response()->json([
            'redirect_url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // Log::info('Google User:', ['user' => $user]);
            $findUser = User::where('social_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser,true);
                $token = $findUser->createToken('google-auth')->plainTextToken;

                return response()->json(['token' => $token]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => Hash::make('google-pass')
                ]);

                Auth::login($newUser,true);
                $token = $newUser->createToken('google-auth')->plainTextToken;

                return response()->json(['token' => $token]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}