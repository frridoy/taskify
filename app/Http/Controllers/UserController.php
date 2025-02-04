<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|integer|in:1,2,3',
            'phone_no' => 'required|string|max:15',
            'status' => 'required|in:0,1',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'phone_no' => $request->get('phone_no'),
            'status' => $request->get('status'),
            'password' => bcrypt($request->get('password')),
        ]);

        $user->save();

        // return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function index()
    {
        $users = User::where('role', '!=', 1)->get();
        return view('users.index', compact('users'));
    }
}
