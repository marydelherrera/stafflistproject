<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userstable()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function addUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'fullname' => 'required|min:2|max:255',
                'email'    => 'required|email|unique:users',
                'role'     => 'required|in:admin,staff',
                'password' => 'required|min:6|confirmed',
            ]);

            User::create([
                'name'     => $validated['fullname'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
            ]);

            return response()->json(['success' => true, 'message' => 'Staff member added successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'fullname' => 'required|min:2|max:255',
                'email'    => 'required|email|unique:users,email,' . $id,
                'role'     => 'required|in:admin,staff',
            ]);

            $user->update([
                'name'  => $validated['fullname'],
                'email' => $validated['email'],
                'role'  => $validated['role'],
            ]);

            return response()->json(['success' => true, 'message' => 'Staff member updated successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Staff member deleted successfully!');
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $userId = session('user')['id'];
            $user   = User::findOrFail($userId);

            $validated = $request->validate([
                'name'  => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email,' . $userId,
            ]);

            $user->update($validated);

            session(['user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]]);

            return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $userId = session('user')['id'];
            $user   = User::findOrFail($userId);

            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:6|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Current password is incorrect.'], 422);
            }

            $user->update(['password' => Hash::make($request->password)]);

            return response()->json(['success' => true, 'message' => 'Password changed successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}