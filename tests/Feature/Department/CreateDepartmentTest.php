<?php

use Inertia\Testing\AssertableInertia as Assert;

test('department can be added', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('department.store'), [
            'department' => 'AML',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Aml')
                    ->etc())
        )
    ;
});

test('department cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('department.store', [
            'department' => '',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->where('errors.department', 'The department field is required.')
        )
    ;
});
