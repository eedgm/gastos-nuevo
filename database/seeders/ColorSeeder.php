<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create(['name' => 'blue', 'color' => 'border-blue-200 text-blue-800 bg-blue-100']);
        Color::create(['name' => 'red', 'color' => 'border-red-200 text-red-800 bg-red-100']);
        Color::create(['name' => 'yellow', 'color' => 'border-yellow-200 text-yellow-800 bg-yellow-100']);
        Color::create(['name' => 'green', 'color' => 'border-green-200 text-green-800 bg-green-100']);
        Color::create(['name' => 'purple', 'color' => 'border-purple-200 text-purple-800 bg-purple-100']);
        Color::create(['name' => 'gray', 'color' => 'border-gray-200 text-gray-800 bg-gray-100']);
    }
}
