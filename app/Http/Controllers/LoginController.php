<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string',
            'role_id'  => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->get('username'))->where('role_id', $request->get('role_id'))->first();

        if ($user == null) {
            return redirect()->back()->with('error', 'email does not exist');
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            return redirect()->back()->with('error', 'Wrong Password');
        }

        \Illuminate\Support\Facades\Session::put('curr_user', $user);

        $user_role = $user->role->title;
        $user_id = $user->id;

        \Illuminate\Support\Facades\Session::put('user_role', $user_role);
        \Illuminate\Support\Facades\Session::put('user_id', $user_id);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
        
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Session::forget('curr_user');
        \Illuminate\Support\Facades\Session::forget('user_role');
        \Illuminate\Support\Facades\Session::forget('user_id');
    
        return response()->json(['message' => 'Logout successful']);
    }
    
}
