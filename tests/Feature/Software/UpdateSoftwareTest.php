<?php


use App\Models\Software;
use Inertia\Testing\AssertableInertia as Assert;

test('software can be update', function () {
    $user = createUser();

    $software = Software::factory()->create([
                    'name' => 'Ms Office',
                    'status' => 'Active',
                    'user_id' => $user->id
                ]);

    $this
        ->actingAs($user)
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Ms Office')
                    ->where('status', 'Active')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('software.update', $software->id), [
            'name' => 'Ms Office',
            'status' => 'In-Active',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Ms Office')
                    ->where('status', 'In-Active')
                    ->etc())
        );
});

test('software cannot be update with missing', function () {
    $user = createUser();

    $software = Software::factory()->create([
                    'name' => 'Ms Office',
                    'status' => 'Active',
                    'user_id' => $user->id
                ]);

    $this
        ->actingAs($user)
        ->get(route('software.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Ms Office')
                    ->where('status', 'Active')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('software.update', $software->id), [
            'name' => 'Teams',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Ms Office')
                    ->where('status', 'Active')
                    ->etc())
                ->where('errors.status', 'The status field is required.')
        );
});
