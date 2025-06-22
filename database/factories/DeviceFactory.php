<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->word(),
            'type' => $this->faker
                ->randomElement([
                    'printer',
                    'laptop',
                    'desktop',
                    'tablet',
                    'mobile',
                    'monitor',
                    'docking station'
                ]),
            'serial_number' => $this->faker->unique()->bothify('SN-#######'),
            'status' => $this->faker->randomElement(['functional', 'non-functional', 'in-repair']),
            'service_status' => $this->faker->randomElement(['assigned', 'available']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
