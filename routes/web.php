<?php

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserContrioller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route for user
    Route::get('/users', [UserContrioller::class,'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserContrioller::class,'edit'])->name('users.edit');
    Route::post('/users/{id}', [UserContrioller::class,'update'])->name('users.update');
    Route::delete('/users/{id}', [UserContrioller::class,'destroy'])->name('users.destroy');


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
    //route for products
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class,'destroy'])->name('products.destroy');


});

require __DIR__.'/auth.php';
