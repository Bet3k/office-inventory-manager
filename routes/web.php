<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceStaffMappingController;
use App\Http\Controllers\MemberOfStaffController;
use App\Http\Controllers\SoftwareController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('member-of-staff', [MemberOfStaffController::class, 'index'])->name('member-of-staff.index');
    Route::get('member-of-staff/{memberOfStaff}', [MemberOfStaffController::class, 'show'])
        ->name('member-of-staff.show');
    Route::post('member-of-staff', [MemberOfStaffController::class, 'store'])->name('member-of-staff.store');
    Route::put('member-of-staff/{memberOfStaff}', [MemberOfStaffController::class, 'update'])
        ->name('member-of-staff.update');
    Route::delete('member-of-staff/{memberOfStaff}', [MemberOfStaffController::class, 'destroy'])
        ->name('member-of-staff.destroy');

    Route::resource('device', DeviceController::class);

    Route::resource('device-staff-mapping', DeviceStaffMappingController::class);

    Route::resource('software', SoftwareController::class);
});

Route::get('/auth/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

require __DIR__.'/web/user_manager.php';

require __DIR__ . '/web/auth.php';
