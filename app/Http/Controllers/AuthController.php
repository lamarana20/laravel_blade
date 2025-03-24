<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUser;
use App\Events\UserSubscribe;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Email;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate
        $fields = $request->validate([
            'name' => ['required', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:3', 'max:255', 'confirmed']
        ]);

        //register
        $user = User::create($fields);
        //login
        Auth::login($user);
        //email verification
        event(new Registered($user));
        if($request->subscribe)
        {
           event(new UserSubscribe($user));
        }
        //send mail
        Mail::to($user->email)->send(new WelcomeUser($user));

        //redirect
        return redirect(route('dashboard'));
    }
    //verify email notice
    public function verifyNotice(Request $request)
    {
        return view('auth.verify-email');
    }
    //verification handler 
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect(route('dashboard'));
    }
   //resending the email verofiaction
  public function  verifyHandler (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');}

    //login
    public function login(Request $request)
    {
        // validate
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3', 'max:255']
        ]);
        // try to login
        if (Auth::attempt($fields, $request->remember)) {
            return redirect()->intended(route('dashboard'));
        } else {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records.',
            ]);
        }
    }
    //logout
    public function logout(Request $request)
    {
       
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}