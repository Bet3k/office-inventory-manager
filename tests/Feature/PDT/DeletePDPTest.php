<?php

use App\Models\PersonalDataProcessed;
use App\Models\PersonalDataType;
use Inertia\Testing\AssertableInertia as Assert;

test('personal data type can be deleted', function () {
    $user = createUser();

    $dataType = PersonalDataType::factory()->create([
                                                'data_type' => 'Name',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Name')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('personal-data-type.destroy', $dataType->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 0)
        );
});

test('personal data type cannot be deleted with wrong password', function () {
    $user = createUser();

    $dataType = PersonalDataType::factory()->create([
                                                'data_type' => 'Names',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('personal-data-type.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Names')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('personal-data-type.destroy', $dataType->id), [
            'password' => 'wong-password-123',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('personal-data-type/index')
                ->has('personal_data_type.data', 1, fn (Assert $page) => $page
                    ->where('data_type', 'Names')
                    ->etc())
                ->where('errors.password', 'The password is incorrect.')
        );
});
