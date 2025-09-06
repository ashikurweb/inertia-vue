<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\TokenExpirationService;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    protected $tokenExpirationService;

    public function __construct(TokenExpirationService $tokenExpirationService)
    {
        $this->tokenExpirationService = $tokenExpirationService;
    }

    public function index()
    {
        return Inertia::render('Frontend/Auth/Register');
    }

    public function store( RegisterRequest $request)
    {
        $validate = $request->validated();
        $user = $this->createUser($validate);

        $this->tokenExpirationService->setSessionExpiration(30);

        $this->loginUser($user);
        return redirect()->route('home')->with('success', 'Account created successfully! Welcome aboard! 🎉');
    }

    private function createUser(array $validate)
    {
        return User::create($validate);
    }

    private function loginUser(User $user)
    {
        Auth::login($user);
    }
}
