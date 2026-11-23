<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LeaderboardController;
use App\Http\Controllers\User\AchievementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::middleware(['auth', EnsureRole::class.':user'])->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements');
});

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', EnsureRole::class.':admin'])->name('admin.dashboard');
