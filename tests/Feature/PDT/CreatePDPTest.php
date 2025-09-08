<?php

use Inertia\Testing\AssertableInertia as Assert;

test('personal data type can be added', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('personal-data-type.store'), [
            'data_type' => 'Name',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Name')
                    ->etc())
        )
    ;
});

test('personal data type cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('personal-data-type.store', [
            'data_type' => '',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->where('errors.data_type', 'The data type field is required.')
        )
    ;
});
