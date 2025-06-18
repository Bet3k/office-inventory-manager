<?php

use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

test('password can be updated', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'Password1#',
            'password' => 'Password12#',
            'password_confirmation' => 'Password12#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    expect(Hash::check('Password12#', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'Password19#',
            'password' => 'Password12#',
            'password_confirmation' => 'Password12#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
                ->has('errors')
                ->where('errors.current_password', 'The password is incorrect.')
        );
});
