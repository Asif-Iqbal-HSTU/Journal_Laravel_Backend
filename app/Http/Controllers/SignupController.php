<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function roles()
    {        
        // Fetch all jobs from the myjobs table
        $Role = Role::all();

        // Return the jobs as JSON
        return response()->json($Role);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'role_id' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User added successfully',
            'user' => $user,
        ], 201);
    }

}
