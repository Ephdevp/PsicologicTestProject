<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create super admin user
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
        ]);

        // Seed test data
        $this->call([
            TestDataSeeder::class,
            QuestionSeeder::class,
            StenAgeSeeder::class,
            InterpretationDataSeeder::class,
        ]);
    }
}
