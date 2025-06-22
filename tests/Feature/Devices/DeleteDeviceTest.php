<?php


use App\Models\Device;
use Inertia\Testing\AssertableInertia as Assert;

test('device can be deleted with correct password', function () {
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
        ->delete(route('device.destroy', $device->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 0)
        );
});

test('device cannot be deleted with wrong password', function () {
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
        ->delete(route('device.destroy', $device->id), [
            'password' => 'wrong-password',
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
                ->where('errors.password', 'The password is incorrect.')
        );
});
