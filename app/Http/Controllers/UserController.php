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

        $user = new User();
        $user->name = ucwords($request->name);
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_no = $request->phone_no;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_photos'), $imageName);
            $user->profile_photo = $imageName;
        }

        $user->save();

        notify()->success('User created successfully.');

        return redirect()->route('users.index');
    }

    public function index(Request $request)
    {
        $query = User::where('role', '!=', 1);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('id') && $request->id != '') {
            $query->where('id', $request->id);
        }

        $users = $query->paginate(5);

        return view('users.index', compact('users'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.create', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|integer|in:1,2,3',
            'phone_no' => 'required|string|max:15',
            'status' => 'required|in:0,1',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_no = $request->phone_no;
        $user->status = $request->status;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
