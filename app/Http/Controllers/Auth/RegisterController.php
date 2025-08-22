<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Auth/Register');
    }

    public function store( RegisterRequest $request)
    {
        $validate = $request->validated();
        $user = $this->createUser($validate);
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
