<?php

use App\Models\Department;
use App\Models\PersonalDataType;
use Inertia\Testing\AssertableInertia as Assert;

test('department can be update', function () {
    $user = createUser();

    $pdp = Department::factory()->create([
                                                'department' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('department.update', $pdp->id), [
            'department' => 'Privatkundendaten',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Privatkundendaten')
                    ->etc())
        );
});

test('department cannot be update with missing', function () {
    $user = createUser();

    $pdp = Department::factory()->create([
                                                'department' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('department.update', $pdp->id), [
            'department' => '',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Bewerberdaten')
                    ->etc())
                ->where('errors.department', 'The department field is required.')
        );
});
