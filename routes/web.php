<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('/dashboard','dashboard')->name('dashboard');

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
