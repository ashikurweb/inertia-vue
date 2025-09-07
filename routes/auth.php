<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::middleware('guest', 'delay:1')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('login/{provider}', [SocialLoginController::class, 'redirect'])->name('social.login');
    Route::get('login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('social.callback');

    Route::get('forgot', [PasswordResetController::class, 'index'])->name('forgot');
    Route::post('forgot', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [PasswordResetController::class, 'resetPassword'])->name('reset.password');
    Route::post('reset/{token}', [PasswordResetController::class, 'resetPasswordStore'])->name('reset.password.update');
    
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
});
    
Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'destroy'])->name('logout');
});