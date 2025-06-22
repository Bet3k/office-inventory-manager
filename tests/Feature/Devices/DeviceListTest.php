<?php

use App\Models\Device;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see devices', function () {
    $user = createUser();

    Device::factory(15)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('device.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 15)
        );
});

test('unauthenticated users cannot see devices', function () {
    $user = createUser();

    Device::factory(15)->create(['user_id' => $user->id]);

    $this
        ->followingRedirects()
        ->get(route('device.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );
});
