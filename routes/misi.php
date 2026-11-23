<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\User\MissionController;
use App\Http\Controllers\User\MissionParticipationController;
use App\Http\Controllers\Admin\MissionController as AdminMissionController;

Route::middleware(['auth', EnsureRole::class.':user'])->name('user.')->group(function () {
    Route::get('/missions', [MissionController::class, 'index'])->name('missions.index');
    Route::get('/missions/{mission}', [MissionController::class, 'show'])->name('missions.show');
    Route::post('/missions/{mission}/join', [MissionParticipationController::class, 'store'])->name('missions.join');
});

Route::middleware(['auth', EnsureRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('missions', AdminMissionController::class)->except(['destroy', 'show']);
});
