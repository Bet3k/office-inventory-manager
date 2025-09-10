<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(string $userId = null): void
    {
        if (!$userId) {
            $this->command->warn('No user ID provided. Skipping department seeding.');
            return;
        }

        $departmentList = [
            'Geschäftsführung',
            'Empfang',
            'Einkauf',
            'Buchhaltung',
            'AML',
            'Responsible Gaming',
            'Management',
            'Marketing & Services',
            'Personalabteilung - HR',
            'Compliance',
            'Support',
            'Sportsbook',
            'onextwo',
            'IT',
            'Franchise',
        ];

        foreach ($departmentList as $department) {
            Department::query()->create([
                                           'department' => $department,
                                           'user_id' => $userId,
                                       ]);
        }
    }
}
