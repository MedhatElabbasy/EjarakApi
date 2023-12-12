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

#admin dashboard

Route::group(  ['prefix' => 'admin/dashboard','middleware' => ['auth', 'role:admin']], function () {

    Route::get('/home', function () {
        return view('Dashboard.index');
    })->name('adminHome');
});




Route::group(  ['prefix' => 'admin/dashboard','middleware' => ['auth', 'role:admin'],'as'=>'admin.dashboard.'], function () {
    Route::get('/real-steat', function () {
        return view('Dashboard.index');
    })->name('realEstate');

    Route::get('/category', function () {
        return view('Dashboard.category.index');
    })->name('category');
});