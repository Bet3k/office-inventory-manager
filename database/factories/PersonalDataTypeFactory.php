<?php

namespace Database\Factories;

use App\Models\PersonalDataType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PersonalDataTypeFactory extends Factory
{
    protected $model = PersonalDataType::class;

    public function definition(): array
    {
        return [
            'data_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
