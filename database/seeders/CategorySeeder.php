<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Entradas', 'slug' => 'entradas'],
            ['name' => 'Pratos Principais', 'slug' => 'pratos-principais'],
            ['name' => 'Sobremesas', 'slug' => 'sobremesas'],
            ['name' => 'Bebidas', 'slug' => 'bebidas'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate($cat);
        }
    }
}
