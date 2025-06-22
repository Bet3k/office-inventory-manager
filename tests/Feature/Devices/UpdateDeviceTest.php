<?php


use App\Models\Device;
use Inertia\Testing\AssertableInertia as Assert;

test('device can be update', function () {
    $user = createUser();

    $device = Device::factory()->create([
                        'brand' => 'Apple',
                        'type' => 'Mobile',
                        'serial_number' => 'SN-1234567',
                        'status' => 'Functional',
                        'service_status' => 'Available',
                        'user_id' => $user->id
                    ]);

    $this
        ->actingAs($user)
        ->get(route('device.index'))
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
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('device.update', $device->id), [
            'brand' => 'Apple',
            'type' => 'mobile',
            'serial_number' => 'SN-1234567',
            'status' => 'Non-Functional',
            'service_status' => 'Decommissioned',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 1, fn (Assert $page) => $page
                    ->where('brand', 'Apple')
                    ->where('type', 'Mobile')
                    ->where('serial_number', 'SN-1234567')
                    ->where('status', 'Non-Functional')
                    ->where('service_status', 'Decommissioned')
                    ->etc())
        );
});

test('device cannot be update with missing', function () {
    $user = createUser();

    $device = Device::factory()->create([
                                            'brand' => 'Apple',
                                            'type' => 'Mobile',
                                            'serial_number' => 'SN-1234567',
                                            'status' => 'Functional',
                                            'service_status' => 'Available',
                                            'user_id' => $user->id
                                        ]);

    $this
        ->actingAs($user)
        ->get(route('device.index'))
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
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('device.update', $device->id), [
            'brand' => 'Apple',
            'type' => 'mobile',
            'status' => 'Non-Functional',
            'service_status' => 'Decommissioned',
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
                ->where('errors.serial_number', 'The serial number field is required.')
        );
});
