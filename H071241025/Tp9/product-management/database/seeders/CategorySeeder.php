<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Perangkat elektronik seperti laptop, ponsel, dan lainnya.',
        ]);

        Category::create([
            'name' => 'Pakaian',
            'description' => 'Berbagai jenis pakaian untuk pria, wanita, dan anak-anak.',
        ]);

        Category::create([
            'name' => 'Makanan & Minuman',
            'description' => 'Produk makanan dan minuman kemasan.',
        ]);
    }
}
