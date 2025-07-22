<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Lanches'],
            ['id' => 2, 'name' => 'Pizzas'],
            ['id' => 3, 'name' => 'Saladas'],
            ['id' => 4, 'name' => 'Bebidas'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
