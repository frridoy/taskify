<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeContoller extends Controller
{
    public function home()
    {
        return view('auth.login');
    }
}
