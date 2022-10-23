<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cluster::create(['name' => 'David']);
        Cluster::create(['name' => 'Barú']);
        Cluster::create(['name' => 'Bugaba']);
        Cluster::create(['name' => 'Changuinola']);
        Cluster::create(['name' => 'Chiriquí Grande']);
        Cluster::create(['name' => 'Veraguas']);
        Cluster::create(['name' => 'Chiriquí Oriente']);
        Cluster::create(['name' => 'Panamá']);
    }
}
