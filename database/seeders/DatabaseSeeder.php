<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        $user = User::factory()->create([
            'password' => 'Password1#',
            'email' => 'test@example.com',
        ]);

        MemberOfStaff::factory(23)->create(['user_id' => $user->id]);
    }
}
