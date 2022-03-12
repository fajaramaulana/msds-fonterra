<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    public function index()
    {
        // echo"hehe";
        return view('frontend.welcome-page');
    }
}
