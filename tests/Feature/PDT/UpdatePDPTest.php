<?php

use App\Models\PersonalDataType;
use Inertia\Testing\AssertableInertia as Assert;

test('personal data type can be update', function () {
    $user = createUser();

    $pdp = PersonalDataType::factory()->create([
                                                'data_type' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('personal-data-type.update', $pdp->id), [
            'data_type' => 'Privatkundendaten',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Privatkundendaten')
                    ->etc())
        );
});

test('personal data type cannot be update with missing', function () {
    $user = createUser();

    $pdp = PersonalDataType::factory()->create([
                                                'data_type' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('personal-data-type.update', $pdp->id), [
            'data_type' => '',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Bewerberdaten')
                    ->etc())
                ->where('errors.data_type', 'The data type field is required.')
        );
});
