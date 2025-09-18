<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Factor;

class FactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factors = [
            ['name' => 'A'],
            ['name' => 'B'],
            ['name' => 'C'],
            ['name' => 'E'],
            ['name' => 'F'],
            ['name' => 'G'],
            ['name' => 'H'],
            ['name' => 'I'],
            ['name' => 'L'],
            ['name' => 'M'],
            ['name' => 'N'],
            ['name' => 'O'],
            ['name' => 'Q1'],
            ['name' => 'Q2'],
            ['name' => 'Q3'],
            ['name' => 'Q4'],
        ];

        foreach ($factors as $factor) {
            Factor::create($factor);
        }
    }
}
