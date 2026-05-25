<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|min:2|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->fullname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'staff' 
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password')->withInput();
        }

        session([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]
        ]);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Welcome Admin!');
        } else {
            return redirect('/staff/dashboard')->with('success', 'Welcome!');
        }
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}