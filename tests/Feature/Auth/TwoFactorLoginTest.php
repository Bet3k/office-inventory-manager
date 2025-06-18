<?php

use Inertia\Testing\AssertableInertia as Assert;
use PragmaRX\Google2FA\Google2FA;

test('users can authenticate with valid 2fa code', function () {
    $user = twoFactorUser();

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
                ->component('auth/two-factor-challenge')
                ->where('errors', [])
        );

    $google2fa = new Google2FA();
    $decryptedSecret = Crypt::decrypt($user->two_factor_secret);
    $freshOtp = $google2fa->getCurrentOtp($decryptedSecret);

    $this
        ->followingRedirects()
        ->post(route('two-factor.login.store'), [
            'code' => $freshOtp,
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('dashboard')
                ->has('auth.user')
                ->where('auth.user.email', $user->email)
        );
});

test('users cannot authenticate with invalid 2fa code', function () {
    $user = twoFactorUser();

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
                ->component('auth/two-factor-challenge')
                ->where('errors', [])
        );

    $this
        ->followingRedirects()
        ->post(route('two-factor.login.store'), [
            'code' => '123963',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/two-factor-challenge')
                ->has('errors')
                ->where('errors.code', 'The provided two factor authentication code was invalid.')
        );
});
