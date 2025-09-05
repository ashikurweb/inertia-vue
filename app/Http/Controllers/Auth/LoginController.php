<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Services\TokenExpirationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $tokenExpirationService;

    public function __construct(TokenExpirationService $tokenExpirationService)
    {
        $this->tokenExpirationService = $tokenExpirationService;
    }

    public function index()
    {
        // Redirect if user is already authenticated
        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'You are already logged in!');
        }
        return Inertia::render('Frontend/Auth/Login');
    }

    public function store (LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember') && $request->input('remember') == 'on';
        
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $this->tokenExpirationService->setSessionExpiration(env('SESSION_EXPIRY_DAYS', 30));

            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back! You have been successfully logged in.');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been successfully logged out.');
    }
}
