<?php

use App\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;

test('reset password link screen can be rendered', function () {
    $this
        ->get(route('forgot-password.create'))
        ->assertInertia(
            fn (Assert $page) => $page
            ->component('auth/forgot-password')
        );
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = createUser();

    $this
        ->followingRedirects()
        ->post(route('forgot-password.store'), [
            'email' => $user->email
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
                ->has('flash')
                ->where('flash.success', 'A reset link has been sent to your E-Mail.')
        );

    Notification::assertSentTo($user, ForgotPasswordNotification::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = createUser();

    $this->post(route('forgot-password.store'), ['email' => $user->email]);

    Notification::assertSentTo($user, ForgotPasswordNotification::class, function ($notification) use ($user) {
        $this
            ->get(route('password.reset', ['token' => $notification->token(), 'id' => $user->id]))
                ->assertInertia(
                    fn (Assert $page) => $page
                        ->component('auth/reset-password')
                );

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = createUser();

    $this->post(route('forgot-password.store'), ['email' => $user->email]);

    Notification::assertSentTo($user, ForgotPasswordNotification::class, function ($notification) use ($user) {
        $this
            ->followingRedirects()
            ->post(route('password.store'), [
                'token' => $notification->token(),
                'id' => $user->id,
                'password' => 'Password1#',
                'password_confirmation' => 'Password1#',
            ])
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('auth/login')
            );
        return true;
    });
});
