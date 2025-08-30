<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserContrioller;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function(){

Route::view('/dashboard','dashboard')->name('dashboard');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
// Profile Routes
Route::get('/profile', [ProfileController::class,'index'])->name('profile.index');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

//route for permission
Route::get('/permissions', [PermissionsController::class,'index'])->name('permissions.index');
Route::get('/permissions/create', [PermissionsController::class,'create'])->name('permissions.create');
Route::post('/permissions', [PermissionsController::class,'store'])->name('permissions.store');
Route::get('/permissions/{id}/edit', [PermissionsController::class,'edit'])->name('permissions.edit');
Route::post('/permissions/{id}', [PermissionsController::class,'update'])->name('permissions.update');
Route::delete('/permissions/{id}', [PermissionsController::class,'destroy'])->name('permissions.destroy');
//route for roles
Route::get('/roles', [RoleController::class,'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class,'create'])->name('roles.create');
Route::post('/roles', [RoleController::class,'store'])->name('roles.store');
Route::get('/roles/{id}/edit', [RoleController::class,'edit'])->name('roles.edit');
Route::post('/roles/{id}', [RoleController::class,'update'])->name('roles.update');
Route::delete('/roles/{id}', [RoleController::class,'destroy'])->name('roles.destroy');
//route for user
Route::get('/users', [UserContrioller::class,'index'])->name('users.index');
// Route::get('/roles/create', [RoleController::class,'create'])->name('roles.create');
// Route::post('/roles', [RoleController::class,'store'])->name('roles.store');
Route::get('/users/{id}/edit', [UserContrioller::class,'edit'])->name('users.edit');
Route::post('/users/{id}', [UserContrioller::class,'update'])->name('users.update');


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

