<?php

use App\Models\Department;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see department list', function () {
    $user = createUser();

    Department::factory(10)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 10)
        );
});

test('unauthenticated users cannot see department list', function () {
    $user = createUser();

    Department::factory(5)->create(['user_id' => $user->id]);

    $this
        ->followingRedirects()
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );
});
