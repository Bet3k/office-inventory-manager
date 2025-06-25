<?php


use App\Models\Software;
use Inertia\Testing\AssertableInertia as Assert;

test('software can be deleted', function () {
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
        ->delete(route('software.destroy', $software->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 0)
        );
});

test('software cannot be deleted with wrong password', function () {
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
        ->delete(route('software.destroy', $software->id), [
            'password' => 'wong-password-123',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('software/index')
                ->has('software.data', 1, fn (Assert $page) => $page
                    ->where('name', 'Ms Office')
                    ->where('status', 'Active')
                    ->etc())
                ->where('errors.password', 'The password is incorrect.')
        );
});
