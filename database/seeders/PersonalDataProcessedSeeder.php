<?php

namespace Database\Seeders;

use App\Models\PersonalDataProcessed;
use Illuminate\Database\Seeder;

class PersonalDataProcessedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(string $userId = null): void
    {
        if (!$userId) {
            $this->command->warn('No user ID provided. Skipping personal-data-processed seeding.');
            return;
        }

        $personalDataProcessedList = [
            'Privatkundendaten',
            'Geschäftskundendaten',
            'Daten von Geschäftspartnern',
            'Mitarbeiterdaten',
            'Behördendaten',
            'Bewerberdaten',
        ];

        foreach ($personalDataProcessedList as $name) {
            PersonalDataProcessed::query()->create([
                                 'name' => $name,
                                 'user_id' => $userId,
                             ]);
        }
    }
}
