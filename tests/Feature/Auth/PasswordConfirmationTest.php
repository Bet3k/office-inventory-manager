<?php

use Inertia\Testing\AssertableInertia as Assert;

test('confirm password screen can be rendered', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('password.confirm'))
        ->assertInertia(
            fn (Assert $page) => $page
            ->component('auth/confirm-password')
        );
});

test('password can be confirmed', function () {
    $user = createUser();

    $response = $this->actingAs($user)->post(route('password-confirm.store'), [
        'password' => 'Password1#',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = createUser();

    $this->get(route('password.confirm'));

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->post(route('password-confirm.store'), [
            'password' => 'wrong-password',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/confirm-password')
                ->has('errors')
                ->where('errors.password', 'The provided password is incorrect.')
        );
});
