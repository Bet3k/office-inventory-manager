<?php

namespace Database\Factories;

use App\Models\PersonalDataProcessed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PersonalDataProcessedFactory extends Factory
{
    protected $model = PersonalDataProcessed::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
