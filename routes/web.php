<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\MemberOfStaffController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('member-of-staff', [MemberOfStaffController::class, 'index'])->name('member-of-staff.index');
});

Route::get('/auth/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

require __DIR__.'/web/user_manager.php';

require __DIR__ . '/web/auth.php';
