<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
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
    Route::get('/users/create', [UserContrioller::class, 'create'])->name('users.create');
    Route::post('/users', [UserContrioller::class, 'store'])->name('users.store');
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
    //route for company

    Route::get('/companies', [CompanyController::class,'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class,'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class,'store'])->name('companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class,'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyController::class,'update'])->name('companies.update');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    // Branch Routes
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
    Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
    Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/branches/{branch}/edit', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('/branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
    Route::get('/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');
    Route::put('/branches/{branch}/toggle-status', [BranchController::class,'toggleStatus'])->name('branches.toggleStatus');
        // Buildings Routes
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
    Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
    Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
    Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');
    Route::delete('/buildings/{id}', [BuildingController::class,'destroy'])->name('buildings.destroy');

    // floors Routes
    Route::get('/floors', [FloorController::class, 'index'])->name('floors.index');
    Route::get('/floors/create', [FloorController::class, 'create'])->name('floors.create');
    Route::post('/floors', [FloorController::class, 'store'])->name('floors.store');
    Route::get('/floors/{floor}/edit', [FloorController::class, 'edit'])->name('floors.edit');
    Route::put('/floors/{floor}', [FloorController::class, 'update'])->name('floors.update');
    Route::delete('/floors/{id}', [FloorController::class,'destroy'])->name('floors.destroy');

        // flate Routes
    Route::get('/flats', [FlatController::class, 'index'])->name('flats.index');
    Route::get('/flats/create', [FlatController::class, 'create'])->name('flats.create');
    Route::post('/flats', [FlatController::class, 'store'])->name('flats.store');
    Route::get('/flats/{flat}/edit', [FlatController::class, 'edit'])->name('flats.edit');
    Route::put('/flats/{flat}', [FlatController::class, 'update'])->name('flats.update');
    Route::delete('/flats/{id}', [FlatController::class,'destroy'])->name('flats.destroy');

    // room Routes
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [RoomController::class,'destroy'])->name('rooms.destroy');

    // seat Routes
    Route::get('/seats', [SeatController::class, 'index'])->name('seats.index');
    Route::get('/seats/create', [SeatController::class, 'create'])->name('seats.create');
    Route::post('/seats', [SeatController::class, 'store'])->name('seats.store');
    Route::get('/seats/{seat}/edit', [SeatController::class, 'edit'])->name('seats.edit');
    Route::put('/seats/{seat}', [SeatController::class, 'update'])->name('seats.update');
    Route::delete('/seats/{id}', [SeatController::class,'destroy'])->name('seats.destroy');
    Route::get('/buildings/{id}/flats', [SeatController::class, 'getFlats']);
    Route::get('/flats/{id}/rooms', [SeatController::class, 'getRooms']);



    /** Members */
    Route::get('/members',                [MemberController::class,'index'])->name('members.index');
    Route::get('/members/suspended',      [MemberController::class,'suspended'])->name('members.suspended');
    Route::get('/members/create',         [MemberController::class,'create'])->name('members.create');
    Route::post('/members',               [MemberController::class,'store'])->name('members.store');
    Route::get('/members/{id}',           [MemberController::class,'show'])->name('members.show');
    Route::get('/members/{id}/edit',      [MemberController::class,'edit'])->name('members.edit');
    Route::put('/members/{id}',           [MemberController::class,'update'])->name('members.update');
    Route::delete('/members/{id}',        [MemberController::class,'destroy'])->name('members.destroy');

    Route::patch('/members/{id}/suspend',   [MemberController::class,'suspend'])->name('members.suspend');
    Route::patch('/members/{id}/reactivate',[MemberController::class,'reactivate'])->name('members.reactivate');

    /** Dependent select JSON endpoints */
    Route::get('/members/deps/branches/{company}',  [MemberController::class,'branchesByCompany'])->name('members.deps.branches');
    Route::get('/members/deps/buildings/{branch}',  [MemberController::class,'buildingsByBranch'])->name('members.deps.buildings');
    Route::get('/members/deps/floors/{building}',   [MemberController::class,'floorsByBuilding'])->name('members.deps.floors');
    Route::get('/members/deps/flats/{floor}',       [MemberController::class,'flatsByFloor'])->name('members.deps.flats');
    Route::get('/members/deps/rooms/{flat}',        [MemberController::class,'roomsByFlat'])->name('members.deps.rooms');
    Route::get('/members/deps/seats/{room}',        [MemberController::class,'seatsByRoom'])->name('members.deps.seats');

    


});

require __DIR__.'/auth.php';
