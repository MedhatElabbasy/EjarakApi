<?php

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthGoogleController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\AuthVerifyPinMailController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
#########     Start  authantication  ########################
// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->group(function () {
    // Authenticated user details
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    // Verify Email   //verify Email  after register
    Route::post('email/verify', [AuthVerifyPinMailController::class, 'verifyEmail']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Unauthenticated routes
Route::post('login', [AuthController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
   //verify Email  after forget password
Route::post('/verify/pin', [AuthVerifyPinMailController::class, 'verifyPin']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);



//google auth
Route::get('auth/google', [AuthGoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthGoogleController::class, 'handleGoogleCallback'])->middleware('auth:sanctum');

#########     End  authantication  ########################
