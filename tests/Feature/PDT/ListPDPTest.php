<?php

use App\Models\PersonalDataType;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see personal data type list', function () {
    $user = createUser();

    PersonalDataType::factory(10)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 10)
        );
});

test('unauthenticated users cannot see personal data type list', function () {
    $user = createUser();

    PersonalDataType::factory(5)->create(['user_id' => $user->id]);

    $this
        ->followingRedirects()
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );
});
