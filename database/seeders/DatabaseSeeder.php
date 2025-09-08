<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
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
        /** @var User $user */
        $user = User::factory()
            ->create([
                'password' => 'Password1#',
                'email' => 'isaac.hatilima@bet3000-entertainment.de',
            ]);

        $role = Role::create(['name' => 'super-admin']);

        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        $user->assignRole('super-admin');

        // Seed Software
        $this->callWith(SoftwareSeeder::class, ['userId' => $user->id]);
        // Persona Data Processed
        $this->callWith(PersonalDataProcessedSeeder::class, ['userId' => $user->id]);
        // Persona Data Type
        $this->callWith(PersonalDataTypeSeeder::class, ['userId' => $user->id]);
    }
}
