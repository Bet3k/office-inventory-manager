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
        $status = $this->faker->randomElement(['Functional', 'Non-Functional', 'In-Repair']);

        return [
            'brand' => Str::title($this->faker->word()),
            'type' => $this->faker->randomElement([
                                                      'Printer',
                                                      'Laptop',
                                                      'Desktop',
                                                      'Tablet',
                                                      'Mobile',
                                                      'Monitor',
                                                      'Docking Station'
                                                  ]),
            'serial_number' => $this->faker->unique()->bothify('SN-#######'),
            'status' => $status,
            'service_status' => $status === 'Non-Functional'
                ? 'Decommissioned'
                : $this->faker->randomElement(['Assigned', 'Available']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
        ];
    }

    public function assigned(): DeviceFactory
    {
        return $this->state([
                                'status' => 'Functional',
                                'service_status' => 'Assigned',
                            ]);
    }
}
