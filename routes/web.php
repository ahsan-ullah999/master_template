<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function(){

Route::view('/dashboard','dashboard')->name('dashboard');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

});

Route::middleware('guest')->group(function(){
//register
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register');
//login
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

});

