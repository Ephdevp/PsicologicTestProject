<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure super_admin level exists
        $levelId = UserLevel::query()->where('level_name', 'super_admin')->value('id');
        if (! $levelId) {
            $levelId = UserLevel::query()->create(['level_name' => 'super_admin'])->id;
        }

        $email = 'superadmin@example.com';

        User::query()->firstOrCreate([
            'email' => $email,
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'), // Change in production
            'user_level_id' => $levelId,
            'remember_token' => Str::random(10),
        ]);

        $email = 'exampleuser@example.com';
        $levelId = 3; // Assuming 'user' level has ID 3
        User::query()->firstOrCreate([
            'email' => $email,
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'), // Change in production
            'user_level_id' => $levelId,
            'remember_token' => Str::random(10),
        ]);
    }
}
