<?php

use Inertia\Testing\AssertableInertia as Assert;

test('registration screen can be rendered', function () {
    $this
        ->get(route('register.create'))
        ->assertInertia(
            fn (Assert $page) => $page
        ->component('auth/register')
        );
});

test('new users can register', function () {
    $this->get(route('register.create'));

    $this
        ->followingRedirects()
        ->post(route('register.store'), [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/verify-email')
                ->where('auth.user.email', 'test@example.com')
                ->where('auth.user.email_verified_at', null)
        );

    $this->assertAuthenticated();
});
