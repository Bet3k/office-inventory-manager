<?php

namespace Database\Seeders;

use App\Models\Software;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($userId = null): void
    {
        if (!$userId) {
            $this->command->warn('No user ID provided. Skipping software seeding.');
            return;
        }

        $softwareList = [
            'ELO',
            'XERO',
            'Rocket',
            'onextwo',
            'Zendesk',
            'Insic',
            'Asana',
            'retech',
            'Akarion',
            'Comply Radar',
            'Slack',
            'Time Reporting System',
            'Datev',
            'Franchise Web',
            'Outlook',
            'Skype',
            'WhatsApp',
            'Sodexo',
            'Microsoft Teams',
            'ReGaweb',
        ];

        foreach ($softwareList as $name) {
            Software::create([
                                 'name' => $name,
                                 'status' => 'Active',
                                 'user_id' => $userId,
                             ]);
        }
    }
}
