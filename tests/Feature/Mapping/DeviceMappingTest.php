<?php


use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Models\MemberOfStaff;
use Inertia\Testing\AssertableInertia as Assert;

test('device can be assigned', function () {
    $user = createUser();

    $memberOfStaff = MemberOfStaff::factory()->create();

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
        ->post(route('device-staff-mapping.store'), [
            'device_id' => $device->id,
            'member_of_staff_id' => $memberOfStaff->id,
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 1, fn (Assert $page) => $page
                    ->where('brand', 'Apple')
                    ->where('type', 'Mobile')
                    ->where('serial_number', 'SN-1234567')
                    ->where('status', 'Functional')
                    ->where('service_status', 'Assigned')
                    ->etc())
        );
});

test('device can be assigned while assigned', function () {
    $user = createUser();

    $memberOfStaff = MemberOfStaff::factory()->create();

    $device = Device::factory()->create([
                                            'brand' => 'Apple',
                                            'type' => 'Mobile',
                                            'serial_number' => 'SN-1234567',
                                            'status' => 'Functional',
                                            'service_status' => 'Assigned',
                                            'user_id' => $user->id
                                        ]);

    DeviceStaffMapping::create([
        'user_id' => $user->id,
        'device_id' => $device->id,
        'member_of_staff_id' => $memberOfStaff->id,
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
                    ->where('service_status', 'Assigned')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('device-staff-mapping.store'), [
            'device_id' => $device->id,
            'member_of_staff_id' => $memberOfStaff->id,
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('devices/index')
                ->has('devices.data', 1, fn (Assert $page) => $page
                    ->where('brand', 'Apple')
                    ->where('type', 'Mobile')
                    ->where('serial_number', 'SN-1234567')
                    ->where('status', 'Functional')
                    ->where('service_status', 'Assigned')
                    ->etc())
                ->where('errors.device_id', 'The device id has already been taken.')
        );
});

test('device can be returned', function () {
    $user = createUser();

    $memberOfStaff = MemberOfStaff::factory()->create();

    $device = Device::factory()->create([
                                            'brand' => 'Apple',
                                            'type' => 'Mobile',
                                            'serial_number' => 'SN-1234567',
                                            'status' => 'Functional',
                                            'service_status' => 'Assigned',
                                            'user_id' => $user->id
                                        ]);

    $mapping = DeviceStaffMapping::create([
                                   'user_id' => $user->id,
                                   'device_id' => $device->id,
                                   'member_of_staff_id' => $memberOfStaff->id,
                               ]);

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->get(route('member-of-staff.show', $memberOfStaff->id))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/staff-details')
                ->has('deviceStaffMappings.data', 1, fn (Assert $page) => $page
                    ->where('brand', 'Apple')
                    ->where('type', 'Mobile')
                    ->where('serial_number', 'SN-1234567')
                    ->where('status', 'Functional')
                    ->where('service_status', 'Assigned')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('device-staff-mapping.destroy', $mapping->id), [
            'password' => 'Password1#'
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/staff-details')
                ->has('deviceStaffMappings.data', 0)
        );
});
