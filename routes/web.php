<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function(){

Route::view('/dashboard','dashboard')->name('dashboard');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::view('/profile','pages.profile')->name('profile');

});

Route::middleware('guest')->group(function(){
//register
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register');
//login
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');

});

