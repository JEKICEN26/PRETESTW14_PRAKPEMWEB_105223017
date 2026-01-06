<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;     
use App\Models\Category; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. Buat Kategori
        $catElektronik = Category::create(['name' => 'Elektronik']);
        $catGelas = Category::create(['name' => 'Alat Gelas']);
        $catKimia = Category::create(['name' => 'Bahan Kimia']);

        // 3. Buat Barang (Items) dan hubungkan dengan Kategori
        Item::create([
            'name' => 'Mikroskop Digital',
            'description' => 'Mikroskop pembesaran 1000x',
            'stock' => 5,
            'category_id' => $catElektronik->id, // Masuk kategori Elektronik
        ]);

        Item::create([
            'name' => 'Laptop Lab',
            'description' => 'Lenovo Thinkpad untuk Analisa',
            'stock' => 2,
            'category_id' => $catElektronik->id,
        ]);

        Item::create([
            'name' => 'Tabung Reaksi',
            'description' => 'Ukuran 10ml',
            'stock' => 50,
            'category_id' => $catGelas->id, // Masuk kategori Alat Gelas
        ]);

        Item::create([
            'name' => 'Asam Sulfat (H2SO4)',
            'description' => 'Konsentrasi 98%',
            'stock' => 10,
            'category_id' => $catKimia->id, // Masuk kategori Bahan Kimia
        ]);
    }
}
