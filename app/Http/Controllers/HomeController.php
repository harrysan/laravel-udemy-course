<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home() {
        return view('home.index');
    }

    public function contact() {
        return view('home.contact');
    }
}
