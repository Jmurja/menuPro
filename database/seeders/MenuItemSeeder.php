<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que pelo menos uma categoria exista
        $category = Category::firstOrCreate(
            ['slug' => 'entradas'],
            ['name' => 'Entradas']
        );

        // Cria os itens com categoria associada
        MenuItem::factory()
            ->count(10)
            ->create([
                'category_id' => $category->id,
            ]);
    }
}
