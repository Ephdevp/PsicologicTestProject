<?php

namespace Database\Seeders;

use App\Models\InterpretationData;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserLevelSeeder::class,
            InterpretationDataSeeder::class,
            StenAgeSeeder::class,
            SuperAdminUserSeeder::class,
            TestSeeder::class,
            TestQuestionsSeeder::class,
            QuestionAnswersSeeder::class,
        ]);
    }
}
