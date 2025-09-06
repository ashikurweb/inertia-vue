<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware('delay:1') // Default 2 seconds delay
  ->name('home');

Route::middleware('auth', 'delay:1')->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


require __DIR__ . '/auth.php';
