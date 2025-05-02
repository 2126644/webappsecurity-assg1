<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    //Display the 2FA code input form
    public function index() 
    {
        //User logged out and directed to 
        return view('auth.two-factor-challenge');
    }

    //Handle code submission
    public function store(Request $request)
    {
        //Validates 2FA code
        $request->validate([
            'two_factor_code' => ['required', 'digits:6'],
        ]);
    
    //Identify user from session (only accepts user stored in session)
    //User must already be partially verified
    $userId = $request->session()->get('login.id');
    
    if(!$userId) 
    {
        return redirect()->route('login')->withErrors(['email' => 'Your session has expired. Please login again.']);
    }

    $user = User::find($userId);

    if($user->two_factor_code !== $request->two_factor_code)
    {
        return back()->withErrors(['two_factor_code' => 'The code is incorrect.']);
    }

    if(Carbon::now()->greaterThan($user->two_factor_expires_at)) 
    {
        return back()->withErrors(['two_factor_code' => 'The code has expired.']);
    }

    //If valid; 
    
    //Clear used 2FA code in database
    $user->two_factor_code = null;
    $user->two_factor_expires_at = null;
    $user->save();

    //Logs user in
    Auth::login($user);

    //Cleans login.id after successful login
    $request->session()->forget('login.id');

    //Redirects to intended page
    return redirect()->intended(config('fortify.home'));
    }
}
