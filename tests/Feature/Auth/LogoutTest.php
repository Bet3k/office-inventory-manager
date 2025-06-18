<?php

use Inertia\Testing\AssertableInertia as Assert;

test('users can logout', function () {
    $user = createUser();

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

    $this
        ->followingRedirects()
        ->post(route('logout'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
                ->where('errors', [])
        );

    $this->assertGuest();
});
