<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('user.dashboard', compact('users', 'roles'));
    }

    public function pagePassword()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('user.changePassword', compact('users', 'roles'));
    }
    

    // Inside the constructor of your UserController
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if the old password matches
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->withErrors(['old_password' => 'Your current password is incorrect.']);
        }

        // Change the password
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success_message', 'Your password has been changed successfully.');
    }

}
