<?php

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');
    Route::put('/profile/{profile}', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile/{profile}', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
