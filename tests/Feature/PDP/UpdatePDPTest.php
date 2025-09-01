<?php

use App\Models\PersonalDataProcessed;
use App\Models\Software;
use Inertia\Testing\AssertableInertia as Assert;

test('personal data processed can be update', function () {
    $user = createUser();

    $pdp = PersonalDataProcessed::factory()->create([
                                                'name' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('personal-data-processed.update', $pdp->id), [
            'name' => 'Privatkundendaten',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Privatkundendaten')
                    ->etc())
        );
});

test('personal data processed cannot be update with missing', function () {
    $user = createUser();

    $pdp = PersonalDataProcessed::factory()->create([
                                                'name' => 'Bewerberdaten',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Bewerberdaten')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('personal-data-processed.update', $pdp->id), [
            'name' => '',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Bewerberdaten')
                    ->etc())
                ->where('errors.name', 'The name field is required.')
        );
});
