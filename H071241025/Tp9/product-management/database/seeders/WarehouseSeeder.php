<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Gudang Makassar',
            'location' => 'Jl. Sultan Alauddin No.45, Makassar',
        ]);

        Warehouse::create([
            'name' => 'Gudang Gowa',
            'location' => 'Jl. Malino No. 45, Gowa',
        ]);

        Warehouse::create([
            'name' => 'Gudang Maros',
            'location' => 'Jl. Poros Maros-Laguna No. 10, Maros',
        ]);
    }
}
