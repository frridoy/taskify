<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 1)->orderBy('created_at', 'desc');

        $allUsers = $query->get();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('id') && $request->id != '') {
            $query->where('id', $request->id);
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users', 'allUsers'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|integer|in:1,2,3',
            'phone_no' => 'required|regex:/^01[3-9]\d{8}$/|string|max:11',
            'status' => 'required|in:0,1',
            'basic_salary' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $user = new User();
        $user->name = ucwords($request->name);
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->role = $request->role;
        $user->phone_no = $request->phone_no;
        $user->status = $request->status;
        $user->basic_salary = $request->basic_salary;
        $user->password = bcrypt($request->password);

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_photos'), $imageName);
            $user->profile_photo = $imageName;
        }

        if ($request->hasFile('employee_signature')) {
            $image = $request->file('employee_signature');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('employee_signatures'), $imageName);
            $user->signature = $imageName;
        }

        $user->save();

        notify()->success('User created successfully.');

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.create', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|integer|in:1,2,3',
            'phone_no' => 'required|regex:/^01[3-9]\d{8}$/|string|max:11',
            'status' => 'required|in:0,1',
            'basic_salary' => 'required|numeric',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->role = $request->role;
        $user->phone_no = $request->phone_no;
        $user->status = $request->status;
        $user->basic_salary = $request->basic_salary;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && file_exists(public_path('profile_photos/' . $user->profile_photo))) {
                unlink(public_path('profile_photos/' . $user->profile_photo));
            }

            $image = $request->file('profile_photo');
            $imageName = time() . '_profile.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_photos'), $imageName);
            $user->profile_photo = $imageName;
        }

        if ($request->hasFile('employee_signature')) {
            if ($user->signature && file_exists(public_path('employee_signatures/' . $user->signature))) {
                unlink(public_path('employee_signatures/' . $user->signature));
            }

            $image = $request->file('employee_signature');
            $imageName = time() . '_signature.' . $image->getClientOriginalExtension();
            $image->move(public_path('employee_signatures'), $imageName);
            $user->signature = $imageName;
        }
        $user->save();

        notify()->success('User updated successfully.');
        return redirect()->route('users.index');
    }

    public function view($userId)
    {
        $user = User::findOrFail($userId);
        return view('users.view', compact('user'));
    }
}
