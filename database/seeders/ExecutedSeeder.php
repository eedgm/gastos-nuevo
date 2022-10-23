<?php

namespace Database\Seeders;

use App\Models\Executed;
use Illuminate\Database\Seeder;

class ExecutedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Executed::factory()
            ->count(5)
            ->create();
    }
}
