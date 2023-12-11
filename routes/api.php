<?php

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthGoogleController;
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
Route::middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class])->group(function () {
    // Your authenticated routes here
});

Route::post('register', [AuthController::class, 'register']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('login', [AuthController::class, 'login']);



//google auth
Route::get('auth/google', [AuthGoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthGoogleController::class, 'handleGoogleCallback'])->middleware('auth:sanctum');




// Route::post('test',function (){
//     $user = User::create([
//         'name' =>'dfvfd',
//         'email' => 'ffdfvd@vgfb',
//         'phone' => 1232434545,
//         'role_id' => 3,
//         'password' => bcrypt('ghnghnghnghnghngh'),
//     ]);
// });