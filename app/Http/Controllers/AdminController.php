<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('admin.dashboard', compact('users', 'roles'));
    }

    public function control()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('admin.control', compact('users', 'roles'));
    }  
    
    public function daftar()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Make sure you have a Role model and it's imported at the top of your controller
        return view('admin.daftar', compact('users', 'roles'));
    }  

    public function updateName(Request $request, $userId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->save();
    
        return response()->json(['success' => 'User name updated successfully.']);
    }    

    public function updateRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Validate the request, for example ensure 'role_id' is a valid role
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
    
        // Use 'sync' method for many-to-many relationship to replace all roles
        $user->roles()->sync([$request->role_id]);
    
        return back()->with('success', 'Role updated successfully.');
    }
    

}

