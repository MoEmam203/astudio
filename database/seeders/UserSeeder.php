<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create default user
        User::factory()->create([
            'first_name' => 'ASTUDIO',
            'last_name' => 'Company',
            'email' => 'astudio@test.com',
        ]);

        User::factory()->count(10)->create();
    }
}
