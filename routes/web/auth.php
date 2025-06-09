<?php

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordManagerController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'create'])
        ->name('login');

    Route::get('/two-factor-challenge', function () {
        return Inertia::render('auth/two-factor-challenge');
    })->name('two-factor.login');

    Route::get('/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('google.redirect');

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

    Route::get('reset-password/{token}/{id}', [PasswordManagerController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [PasswordManagerController::class, 'store'])
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

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [LogoutController::class, 'destroy'])
        ->name('logout');
});
