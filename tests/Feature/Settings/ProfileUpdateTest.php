<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('profile page is displayed', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('profile.show'))
        ->assertInertia(
            fn (Assert $page) => $page
            ->component('profile/index')
            ->has(
                'auth.user',
                fn (Assert $page) => $page
                    ->where('email', $user->email)
                    ->where('profile.first_name', $user->profile->first_name)
                    ->where('profile.last_name', $user->profile->last_name)
                    ->where('profile.gender', $user->profile->gender)
                    ->where('profile.date_of_birth', $user->profile->date_of_birth->format('Y-m-d'))
                    ->etc()
            )
        );
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('profile.show'));

    $response = $this
        ->followingRedirects()
        ->actingAs($user)
        ->put(route('profile.update', $user->profile->id), [
            'email' => 'john.doe@mail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'male',
            'date_of_birth' => '1980-01-01',
        ]);

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('profile/index')
            ->where('errors', [])
    );

    $user->refresh();

    expect($user->email)->toBe('john.doe@mail.com')
        ->and($user->email_verified_at)->not->toBeNull()
        ->and($user->profile->first_name)->toBe('John')
        ->and($user->profile->last_name)->toBe('Doe')
        ->and($user->profile->gender)->toBe('male')
        ->and($user->profile->date_of_birth->format('Y-m-d'))->toBe('1980-01-01');
});

test('email verification status is changed when the email address is unchanged', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('profile.show'));

    $response = $this
        ->followingRedirects()
        ->actingAs($user)
        ->put(route('profile.update', $user->profile->id), [
            'email' => 'john1.doe@mail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'male',
            'date_of_birth' => '1980-01-01',
        ]);

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('profile/index')
            ->where('errors', [])
    );

    $user->refresh();

    expect($user->email)->toBe('john1.doe@mail.com')
        ->and($user->email_verified_at)->toBeNull()
        ->and($user->profile->first_name)->toBe('John')
        ->and($user->profile->last_name)->toBe('Doe')
        ->and($user->profile->gender)->toBe('male')
        ->and($user->profile->date_of_birth->format('Y-m-d'))->toBe('1980-01-01');
});

test('user can delete their account', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('profile.show'));

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->delete(route('profile.destroy', $user->profile->id), [
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
                ->where('errors', [])
        );

    $this->assertGuest();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = createUser();

    $this->actingAs($user)->get(route('profile.show'));

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->delete(route('profile.destroy', $user->profile->id), [
            'password' => 'Password12#',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('profile/index')
                ->has('errors')
                ->where('errors.password', 'The password is incorrect.')
        );

    expect($user->fresh())->not->toBeNull();
});
