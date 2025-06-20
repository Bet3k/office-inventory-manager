<?php

use Inertia\Testing\AssertableInertia as Assert;

test('member of staff can be created', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('member-of-staff.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('member-of-staff.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'John')
                    ->where('last_name', 'Doe')
                    ->etc())
        )
    ;
});

test('members of staff cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('member-of-staff.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('member-of-staff.store', [
            'first_name' => 'John',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->where('errors.last_name', 'The last name field is required.')
        )
    ;
});
