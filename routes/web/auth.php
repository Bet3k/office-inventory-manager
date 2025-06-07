<?php

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'create'])
        ->name('login');

    Route::get('/register', [RegisterUserController::class, 'create'])
        ->name('register.create');
    Route::post('/register', [RegisterUserController::class, 'store'])
        ->name('register.store')
        ->middleware(['throttle:5,1']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('forgot-password.create');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
        ->name('forgot-password.store')
        ->middleware(['throttle:5,1']);

    Route::get('reset-password/{token}/{id}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store')
        ->middleware(['throttle:5,1']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, 'create'])
        ->name('verification.notice');
    Route::post('verify-email', [EmailVerificationPromptController::class, 'store'])
        ->name('verify-email.store');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->name('verification.verify')
        ->middleware(['signed', 'throttle:6,1']);

    Route::post('logout', [LogoutController::class, 'destroy'])
        ->name('logout');
});
