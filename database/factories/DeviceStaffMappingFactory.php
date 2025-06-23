<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Models\MemberOfStaff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DeviceStaffMappingFactory extends Factory
{
    protected $model = DeviceStaffMapping::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'member_of_staff_id' => MemberOfStaff::factory(),
            'device_id' => Device::factory(),
        ];
    }
}
