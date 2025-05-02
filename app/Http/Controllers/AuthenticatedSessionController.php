<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;            //to access form input
use Illuminate\Support\Facades\Auth;    //handle login
use Illuminate\Support\Carbon;          //manage time-based expired logic
use Illuminate\Support\Facades\Mail;    //to send 2FA code
use App\Mail\TwoFactorCodeMail;         //Mailable class that sends the email
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request) 
    {
        //Create a rate limit key
        $key = 'login_attempts:' . $request->email;

        //Checks if the user has exceeded 3 attempts (max) in 1 min
        if(RateLimiter::tooManyAttempts($key, 3))
        {
            return back()->withErrors(['email'=> 'Too many login attempts. Please try again after 1 minute.']);
        }

        //Validate login credentials
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //Manually retrieves the user by email
        $user = User::where('email', $request->email)->first();
        
        //Get the stored salt from the database
        //Concatenate it with the entered password
        //Use Hash::check() manually instead of Auth::attempt()
        if ($user && Hash::check($request->password . $user->salt, $user->password))
        {
            Auth::login($user); //Manually login the user
            $request->session()->regenerate();

            //Generate random 2FA code
            $user->two_factor_code = rand(100000, 999999);                  //random 6-digit code is created 
            $user->two_factor_expires_at = Carbon::now()->addMinutes(10);   //code expires after 10 mins
            /** @var \App\Models\User $user */
            $user->save();                                                  //updates user row for these 2 columns

            //Send 2FA code via email
            Mail::to($user->email)->send(new TwoFactorCodeMail($user));     
            
            //Stores the user's ID in the session
            $request->session()->put('login.id', $user->id);

            //Logout temp until code verified
            Auth::logout();

            RateLimiter::clear($key);   //Clear the previous failed attempts, if any
            return redirect()->route('two-factor.login');   //sends user to 2FA form to input code
        }

        //Count the failed attempt for up to 60 seconds
        //Allow up to 3 attempts per minute
        RateLimiter::hit($key, 60); 

        return back()->withErrors([
            //Shows error for wrong email/password
            'email' => 'The provided email does not match any of our record.',
        ]);
    }
}