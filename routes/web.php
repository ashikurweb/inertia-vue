<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware('delay:1') // Default 2 seconds delay
  ->name('home');


require __DIR__ . '/auth.php';
