<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
   public function passwordReset($userId)
    {
        $user = User::select('id', 'password')->findOrFail($userId);
        $user->password = Hash::make('123456');
        $user->save();

        notify()->success('Password has been reset to 123456');
        return redirect()->back();
    }
}
