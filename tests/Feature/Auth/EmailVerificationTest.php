<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory([
        'email' => 'test@example.com'
    ])->unverified()->create();

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->get('/verify-email')
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/verify-email')
                ->where('auth.user.email', 'test@example.com')
                ->where('auth.user.email_verified_at', null)
        );
});

test('email can be verified', function () {
    $user = User::factory([
        'email' => 'test@example.com'
    ])->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory([
        'email' => 'test@example.com'
    ])->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
