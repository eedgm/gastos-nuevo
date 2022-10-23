<?php

namespace Database\Seeders;

use App\Models\Assign;
use Illuminate\Database\Seeder;

class AssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assign::create(['name' => 'MCA']);
        Assign::create(['name' => 'Ayudante MCA']);
    }
}
