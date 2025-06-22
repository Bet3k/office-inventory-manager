<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'brand' => Str::title($this->faker->word()),
            'type' => $this->faker
                ->randomElement([
                    'Printer',
                    'Laptop',
                    'Desktop',
                    'Tablet',
                    'Mobile',
                    'Monitor',
                    'Docking Station'
                ]),
            'serial_number' => $this->faker->unique()->bothify('SN-#######'),
            'status' => $this->faker->randomElement(['Functional', 'Non-Functional', 'In-Repair']),
            'service_status' => $this->faker->randomElement(['Assigned', 'Available']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
