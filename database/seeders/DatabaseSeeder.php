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
        /** @var User $user */
        $user = User::factory()->create([
                                            'password' => 'Password1#',
                                            'email' => 'test@example.com',
                                        ]);

        /** @var MemberOfStaff $staff */
        $staff = MemberOfStaff::factory(4)->create(['user_id' => $user->id]);

        // Create 30 general devices (mixed statuses)
        Device::factory(30)->create(['user_id' => $user->id]);

        // Create 20 devices explicitly Functional + Assigned
        $assignedDevices = Device::factory()
            ->count(20)
            ->assigned() // use the factory state
            ->create(['user_id' => $user->id]);

        // Assign those to staff
        foreach ($assignedDevices as $device) {
            DeviceStaffMapping::factory()->create([
                                                      'user_id' => $user->id,
                                                      'device_id' => $device->id,
                                                      'member_of_staff_id' => $staff->random()->id,
                                                  ]);
        }
    }
}
