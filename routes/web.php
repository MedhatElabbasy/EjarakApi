<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/dash', [App\Http\Controllers\HomeController::class, 'indexdashdash'])->name('indexdashdash');

#admin dashboard
Route::get('/admin/dashboard/home', function () {
    return view('Dashboard.index');
})->middleware('role:admin')->name('adminHome');



Route::group(  ['prefix' => 'admin/dashboard','middleware' => ['auth', 'role:admin'],'as'=>'admin.dashboard.'], function () {
    Route::get('/real-steat', function () {
        return view('Dashboard.index');
    })->name('realEstate');

    Route::get('/category', function () {
        return view('Dashboard.index');
    })->name('category');
});