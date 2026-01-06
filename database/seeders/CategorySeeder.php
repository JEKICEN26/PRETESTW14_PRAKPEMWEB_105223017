<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Alat Gelas',
            'Bahan Kimia',
            'Perkakas'
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}