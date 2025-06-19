<?php

use Inertia\Testing\AssertableInertia as Assert;
use PragmaRX\Google2FA\Google2FA;

test('user can activate 2fa', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->post(route('password-confirm.store'), [
            'password' => 'Password1#',
        ]);

    $this
        ->followingRedirects()
        ->post(route('two-factor.enable'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    expect($user->two_factor_secret)->not->toBeNull()
        ->and($user->two_factor_recovery_codes)->not->toBeNull()
        ->and($user->two_factor_confirmed_at)->toBeNull();

});

test('user cannot activate 2fa with wrong password', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->post(route('password-confirm.store'), [
            'password' => 'Password12#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
                ->where('errors.password', 'The provided password is incorrect.')
        );

    expect($user->two_factor_secret)->toBeNull()
        ->and($user->two_factor_recovery_codes)->toBeNull()
        ->and($user->two_factor_confirmed_at)->toBeNull();

});

test('user can deactivate 2fa', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->post(route('password-confirm.store'), [
            'password' => 'Password1#',
        ]);

    $this
        ->followingRedirects()
        ->delete(route('two-factor.enable'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    expect($user->two_factor_secret)->toBeNull()
        ->and($user->two_factor_recovery_codes)->toBeNull()
        ->and($user->two_factor_confirmed_at)->toBeNull();

});

test('user can activate and confirm 2fa', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->post(route('password-confirm.store'), [
            'password' => 'Password1#',
        ]);

    $this
        ->followingRedirects()
        ->post(route('two-factor.enable'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    $user->refresh();

    $decryptedSecret = Crypt::decrypt($user->two_factor_secret);

    $google2fa = new Google2FA();
    $otp = $google2fa->getCurrentOtp($decryptedSecret);
    $this
        ->followingRedirects()
        ->post(route('two-factor.confirm'), [
            'code' => $otp,
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    expect($user->two_factor_secret)->not->toBeNull()
        ->and($user->two_factor_recovery_codes)->not->toBeNull()
        ->and($user->two_factor_confirmed_at)->not->toBeNull();

});

test('user cannot activate and confirm 2fa with wrong code', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->followingRedirects()
        ->post(route('password-confirm.store'), [
            'password' => 'Password1#',
        ]);

    $this
        ->followingRedirects()
        ->post(route('two-factor.enable'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    $user->refresh();

    $this
        ->followingRedirects()
        ->post(route('two-factor.confirm'), [
            'code' => '123658',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    expect($user->two_factor_secret)->not->toBeNull()
        ->and($user->two_factor_recovery_codes)->not->toBeNull()
        ->and($user->two_factor_confirmed_at)->toBeNull();
});
