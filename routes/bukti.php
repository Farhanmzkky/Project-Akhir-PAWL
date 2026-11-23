<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\User\SubmissionController;
use App\Http\Controllers\Admin\SubmissionReviewController;
use App\Http\Controllers\PhotoController;

Route::get('/evidence/photos/{photo}', [PhotoController::class, 'show'])
    ->middleware(['auth', EnsureRole::class.':user,admin'])->name('photos.show');

Route::middleware(['auth', EnsureRole::class.':user'])->name('user.')->group(function () {
    Route::get('/my-missions', [SubmissionController::class, 'index'])->name('my-missions');
    Route::get('/participations/{participant}', [SubmissionController::class, 'show'])->name('evidence');
    Route::post('/participations/{participant}/draft', [SubmissionController::class, 'store'])->name('evidence.draft');
    Route::post('/participations/{participant}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
});

Route::middleware(['auth', EnsureRole::class.':admin'])->prefix('admin/submissions')->name('admin.submissions.')->group(function () {
    Route::get('/', [SubmissionReviewController::class, 'index'])->name('index');
    Route::get('/history', [SubmissionReviewController::class, 'history'])->name('history');
    Route::get('/{submission}', [SubmissionReviewController::class, 'show'])->name('show');
    Route::post('/{submission}/approve', [SubmissionReviewController::class, 'approve'])->name('approve');
    Route::post('/{submission}/reject', [SubmissionReviewController::class, 'reject'])->name('reject');
});
