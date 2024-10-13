<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // At the top of your file

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string',
            'role_id'  => 'required|integer',
            'password' => 'required|string',
        ]);
    
        $user = User::where('username', $request->get('username'))
            ->where('role_id', $request->get('role_id'))
            ->first();
    
        if ($user == null) {
            return response()->json([
                'message' => 'User with this username and role not found',
                'user' => null,
            ], 404);
        }
    
        if (!Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'message' => 'Incorrect password',
                'user' => null,
            ], 401);
        }
    
        // Save user info in session
        // session()->put('curr_user', $user);
        // session()->put('user_role', $user->role->title);
        // session()->put('user_id', $user->id);

        \Illuminate\Support\Facades\Session::put('curr_user', $user);
        \Illuminate\Support\Facades\Session::put('user_role', $user->role->title);
        \Illuminate\Support\Facades\Session::put('user_id', $user->id);
    
        // Log the session data for debugging
        Log::info('Current session data:', session()->all());
    
        // Retrieve the user from the session
        $sessionUser = session()->get('curr_user');
    
        return response()->json([
            'message' => 'Login successful',
            'user' => $sessionUser, // Return the user from session
        ], 200);
    }

    public function getCurrentUser()
    {
        // Retrieve the user from the session
        $sessionUser = session()->get('curr_user');
        return response()->json([
            'user' => $sessionUser, // Return the user from session
        ], 200);
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Session::forget('curr_user');
        \Illuminate\Support\Facades\Session::forget('user_role');
        \Illuminate\Support\Facades\Session::forget('user_id');

        return response()->json(['message' => 'Logout successful'], 200); // 200 OK status
    }
}
