<?php

use Inertia\Testing\AssertableInertia as Assert;

test('login screen can be rendered', function () {
    $this->get(route('login'))
        ->assertInertia(
            fn (Assert $page) => $page
            ->component('auth/login')
        );
});

test('users can authenticate using the login screen', function () {
    $user = createUser();

    $this->get(route('login'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('dashboard')
                ->where('auth.user.email', $user->email)
        );
});

test('users can not authenticate with invalid password', function () {
    $user = createUser();

    $this->get(route('login'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password12#',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
                ->where('errors', [
                    'email' => 'Invalid E-Mail or Password provided.'
                ])
        );

    $this->assertGuest();
});
