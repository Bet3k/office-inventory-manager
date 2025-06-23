<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Models\MemberOfStaff;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'Password1#',
            'email' => 'test@example.com',
        ]);

        // Create staff members
        /** @var MemberOfStaff $staff */
        $staff = MemberOfStaff::factory(4)->create(['user_id' => $user->id]);

        // Create devices
        /** @var Device $devices */
        $devices = Device::factory(50)->create(['user_id' => $user->id]);

        // Filter eligible devices
        $assignableDevices = $devices->filter(function ($device) {
            return $device->status === 'Functional' && $device->service_status === 'Assigned';
        });

        // Assign eligible devices to random staff
        foreach ($assignableDevices as $device) {
            DeviceStaffMapping::factory()->create([
                'user_id' => $user->id,
                'device_id' => $device->id,
                'member_of_staff_id' => $staff->random()->id,
            ]);
        }
    }
}
