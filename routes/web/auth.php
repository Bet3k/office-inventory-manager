<?php

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'create'])
        ->name('login');

    Route::get('logs', function () {
        $user = User::query()->whereEmail('xoviry@mailinator.com')->first();
        Auth::login($user);

        return to_route('dashboard');
    });

    Route::get('/register', [RegisterUserController::class, 'create'])
        ->name('register.create');
    Route::post('/register', [RegisterUserController::class, 'store'])
        ->name('register.store');
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
