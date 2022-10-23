<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Seeder;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purpose::create(['name' => 'Agencia', 'color_id' => 1]);
        Purpose::create(['name' => 'Ayudantes', 'color_id' => 1]);
        Purpose::create(['name' => 'Núcleo', 'color_id' => 2]);
        Purpose::create(['name' => 'Asamblea', 'color_id' => 3]);
        Purpose::create(['name' => 'Cómite', 'color_id' => 4]);
        Purpose::create(['name' => 'Coordinadores', 'color_id' => 4]);
        Purpose::create(['name' => 'Reflexiones', 'color_id' => 6]);
        Purpose::create(['name' => 'JTS', 'color_id' => 4]);
        Purpose::create(['name' => 'Visita', 'color_id' => 4]);
        Purpose::create(['name' => 'Otros', 'color_id' => 5]);
    }
}
