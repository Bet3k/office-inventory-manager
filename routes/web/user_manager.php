<?php

use App\Http\Controllers\Auth\PasswordManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');
    Route::put('/profile/{profile}', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile/{profile}', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/settings', [SettingsController::class, 'create'])
        ->name('settings.create');

    Route::put('/password-update', [PasswordManagerController::class, 'update'])
        ->name('password.update');

    Route::delete('/sessions/{session}', [SessionController::class, 'logoutCurrent'])
        ->name('sessions.destroy');

    Route::delete('/end-all-sessions', [SessionController::class, 'logoutAll'])
        ->name('sessions.end.all');
});
