<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Auth/ForgotPassword');
    }

    /**
     * Send the password reset link to the user's email.
     */

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        $user->remember_token = Str::random(50);
        $user->save();

        // Send the reset password email
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'There was an error sending the password reset email. Please try again later.']);
        }

        return back()->with('success', 'We have emailed your password reset link!');
    }

    /**
     * Show the password reset form with the token.
     */
    public function resetPassword($token)
    {
        // Find the user based on the reset token
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['token' => 'This password reset link is invalid or expired.']);
        }

        return Inertia::render('Frontend/Auth/ResetPassword', compact('user', 'token'));
    }

    public function resetPasswordStore(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user based on the reset token
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['token' => 'This password reset link is invalid or expired.']);
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }
}
