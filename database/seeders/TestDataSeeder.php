<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use App\Enums\UserRole;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test restaurant
        $restaurant = Restaurant::create([
            'name' => 'Restaurante Teste',
            'cnpj' => '12345678901234',
            'zip_code' => '12345678',
            'street' => 'Rua Teste',
            'number' => '123',
            'neighborhood' => 'Bairro Teste',
            'city' => 'Cidade Teste',
            'state' => 'ST',
            'is_active' => true,
        ]);

        // Create test users
        $owner = User::create([
            'name' => 'Dono Teste',
            'email' => 'dono@teste.com',
            'password' => bcrypt('password'),
            'role' => UserRole::DONO,
            'cpf' => '12345678901',
            'phone' => '11987654321',
            'is_active' => true,
        ]);

        $cashier = User::create([
            'name' => 'Caixa Teste',
            'email' => 'caixa@teste.com',
            'password' => bcrypt('password'),
            'role' => UserRole::CAIXA,
            'cpf' => '12345678902',
            'phone' => '11987654322',
            'is_active' => true,
        ]);

        $waiter = User::create([
            'name' => 'Garçom Teste',
            'email' => 'garcom@teste.com',
            'password' => bcrypt('password'),
            'role' => UserRole::GARCOM,
            'cpf' => '12345678903',
            'phone' => '11987654323',
            'is_active' => true,
        ]);

        // Attach users to restaurant
        $restaurant->users()->attach([$owner->id, $cashier->id, $waiter->id]);

        // Create test category
        $category = Category::create([
            'name' => 'Categoria Teste',
            'slug' => 'categoria-teste',
            'restaurant_id' => $restaurant->id,
        ]);

        // Create test menu items
        MenuItem::create([
            'name' => 'Item Teste 1',
            'description' => 'Descrição do item teste 1',
            'price' => 25.90,
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Item Teste 2',
            'description' => 'Descrição do item teste 2',
            'price' => 18.50,
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->command->info('Test data seeded successfully!');
    }
}
