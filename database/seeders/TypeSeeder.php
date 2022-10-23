<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['name' => 'Transporte']);
        Type::create(['name' => 'Comunicación']);
        Type::create(['name' => 'Alimentación']);
        Type::create(['name' => 'Hospedaje']);
    }
}
