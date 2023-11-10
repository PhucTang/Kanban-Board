<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Phase::factory()
            ->count(5)
            ->sequence(
                ['name' => 'Backlog', 'order_number' => 1, "is_completion" => false],
                ['name' => 'To Do', 'order_number' => 2, "is_completion" => false],
                ['name' => 'Doing', 'order_number' => 3, "is_completion" => false],
                ['name' => 'Done', 'order_number' => 4, "is_completion" => true],
                ['name' => 'Archived', 'order_number' => 5, "is_completion" => false],)
            ->create();
    }
}
