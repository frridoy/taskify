<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superAdmin.dashbaord');
    }
    public function home()
    {
        return view('welcome');
    }
}
