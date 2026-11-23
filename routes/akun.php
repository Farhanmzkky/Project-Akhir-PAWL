<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\UserController;

Route::view('/', 'landing')->name('landing');

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:8,1')->name('register.store');
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:8,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', fn () => to_route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard'))->name('home');
});

Route::middleware(['auth', EnsureRole::class.':user'])->group(function () {
    Route::view('/profile', 'user.profile.edit')->name('user.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
});

Route::middleware(['auth', EnsureRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
