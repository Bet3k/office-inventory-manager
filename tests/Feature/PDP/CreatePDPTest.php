<?php

use Inertia\Testing\AssertableInertia as Assert;

test('personal data processed can be added', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('personal-data-processed.store'), [
            'name' => 'Bewerberdaten',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Bewerberdaten')
                    ->etc())
        )
    ;
});

test('personal data processed cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('personal-data-processed.store', [
            'name' => '',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->where('errors.name', 'The name field is required.')
        )
    ;
});
