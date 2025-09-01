<?php

use App\Models\PersonalDataProcessed;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see personal data processed list', function () {
    $user = createUser();

    PersonalDataProcessed::factory(10)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 10)
        );
});

test('unauthenticated users cannot see personal data processed list', function () {
    $user = createUser();

    PersonalDataProcessed::factory(15)->create(['user_id' => $user->id]);

    $this
        ->followingRedirects()
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );
});
