<?php

use App\Models\PersonalDataProcessed;
use Inertia\Testing\AssertableInertia as Assert;

test('personal data processed can be deleted', function () {
    $user = createUser();

    $software = PersonalDataProcessed::factory()->create([
                                                'name' => 'Word',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Word')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('personal-data-processed.destroy', $software->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 0)
        );
});

test('personal data processed cannot be deleted with wrong password', function () {
    $user = createUser();

    $software = PersonalDataProcessed::factory()->create([
                                                'name' => 'Names',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-processed.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Names')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('personal-data-processed.destroy', $software->id), [
            'password' => 'wong-password-123',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-processed/index')
                ->has('personal_data_processed.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Names')
                    ->etc())
                ->where('errors.password', 'The password is incorrect.')
        );
});
