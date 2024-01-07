<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('user.dashboard', compact('users', 'roles'));
    }
}
