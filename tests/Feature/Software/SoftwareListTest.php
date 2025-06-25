<?php

use App\Models\Software;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see software list', function () {
    $user = createUser();

    Software::factory(10)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 10)
        );
});

test('unauthenticated users cannot see software list', function () {
    $user = createUser();

    Software::factory(15)->create(['user_id' => $user->id]);

    $this
        ->followingRedirects()
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );
});
