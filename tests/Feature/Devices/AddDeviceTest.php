<?php


use Inertia\Testing\AssertableInertia as Assert;

test('device can be added', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('device.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('device.store'), [
            'brand' => 'Apple',
            'type' => 'mobile',
            'serial_number' => 'SN-1234567',
            'status' => 'Functional',
            'service_status' => 'Available',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 1, fn (Assert $page) => $page
                    ->where('brand', 'Apple')
                    ->where('type', 'Mobile')
                    ->where('serial_number', 'SN-1234567')
                    ->where('status', 'Functional')
                    ->where('service_status', 'Available')
                    ->etc())
        )
    ;
});

test('device cannot be created with missing data', function () {
    $user = createUser();

    $this
        ->actingAs($user)
        ->get(route('device.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('device.store', [
            'brand' => 'Apple',
            'type' => 'mobile',
            'status' => 'Functional',
            'service_status' => 'Available',
        ]))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->where('errors.serial_number', 'The serial number field is required.')
        )
    ;
});
