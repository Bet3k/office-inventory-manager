<?php


use Inertia\Testing\AssertableInertia as Assert;

test('software can be added', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('software.store'), [
            'name' => 'Microsoft Office',
            'status' => 'Active',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Microsoft Office')
                    ->where('status', 'Active')
                    ->etc())
        )
    ;
});

test('software cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('software.store', [
            'name' => 'Teams',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->where('errors.status', 'The status field is required.')
        )
    ;
});
