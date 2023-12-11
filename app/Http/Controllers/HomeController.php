<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('indexdashdash');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        switch (Auth()->user()->role->name) {
            case 'admin':
                return redirect()->route('adminHome');
                break;

            default:
                # code...
                break;
        }

    }

    public function indexdashdash()
    {
        return view('Dashboard.layouts.app');

    }
}