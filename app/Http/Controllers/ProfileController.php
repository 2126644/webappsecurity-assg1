<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    /** shows the profile details */
    {
        $user = Auth::user(); //returns the currently logged-in user
        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    public function edit()
    /** shows the profile details edit form */
    {
        $user = Auth::user();
        return view('profile.editprofile', compact('user'));
    }

    public function update(Request $request)
    /** validates the request, updates the user record, and saves changes */
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();

        $request->validate([ //checks the form inputs are valid before saving
            'nickname' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users,email,'. $user->id, //exclude this user's current ID from the uniqueness check
            //if they submit the same email again, it won't say “email already taken” (bcs it's theirs)
            'phone_no' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'password' => 'nullable|min:8|confirmed',
            //confirmed = with password_confirmation 
            //nullable = user can leave it blank
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            //gets the uploaded file using $request
            //uploads image in the storage/app/public/avatars
            //return $path = the path to the stored file
            $user->avatar = $path;
            //saves the file path to the avatar column of the user table
        }

        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->city = $request->city;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated.');
    }

    public function destroy()
    {
        /** @var \App\Models\User $user */

        $user = Auth::user(); //get the currently logged-in user
        $user->delete(); //delete the user from the database
        Auth::logout();

        return redirect('/')->with('success', 'Account deleted.');
    }
}
