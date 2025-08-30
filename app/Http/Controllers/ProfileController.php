<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();   // get logged-in user
        return view('pages.profile', compact('user'));
    }

        // Update profile
    public function update(Request $request)
    {
    /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update name & email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if given
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload profile image
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile_images'), $filename);

            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path('uploads/profile_images/' . $user->profile_image))) {
                unlink(public_path('uploads/profile_images/' . $user->profile_image));
            }

            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }

        //for update permission page


}
