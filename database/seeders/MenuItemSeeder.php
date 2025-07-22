<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Hambúrguer Clássico',
                'description' => 'Pão brioche, hambúrguer artesanal, queijo cheddar, alface, tomate e maionese da casa.',
                'price' => 29.90,
                'image_url' => 'https://example.com/images/hamburguer-classico.jpg',
                'category_id' => 1,
                'is_active' => true,
                'stock_quantity' => 50,
                'availability_start_time' => '11:00:00',
                'availability_end_time' => '23:00:00',
            ],
            [
                'name' => 'Pizza Margherita',
                'description' => 'Mussarela, molho de tomate artesanal, manjericão fresco e azeite extra virgem.',
                'price' => 42.00,
                'image_url' => 'https://example.com/images/pizza-margherita.jpg',
                'category_id' => 2,
                'is_active' => true,
                'stock_quantity' => 30,
                'availability_start_time' => '18:00:00',
                'availability_end_time' => '23:59:00',
            ],
            [
                'name' => 'Salada Caesar',
                'description' => 'Alface romana, frango grelhado, croutons, parmesão e molho caesar.',
                'price' => 24.50,
                'image_url' => 'https://example.com/images/salada-caesar.jpg',
                'category_id' => 3,
                'is_active' => true,
                'stock_quantity' => 20,
                'availability_start_time' => '10:00:00',
                'availability_end_time' => '15:00:00',
            ],
            [
                'name' => 'Suco Natural de Laranja',
                'description' => 'Suco fresco de laranja sem açúcar.',
                'price' => 8.00,
                'image_url' => 'https://example.com/images/suco-laranja.jpg',
                'category_id' => 4,
                'is_active' => true,
                'stock_quantity' => 100,
                'availability_start_time' => '08:00:00',
                'availability_end_time' => '22:00:00',
            ]
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
