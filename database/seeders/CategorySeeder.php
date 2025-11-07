<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         // Para cada usuário, criar categorias padrão
        $users = User::all();

        foreach ($users as $user) {
              $defaultCategories = [
                    // Receitas
                    ['name' => 'Vendas', 'type' => 'income', 'color' => '#10B981', 'icon' => '💰'],
                    ['name' => 'Serviços', 'type' => 'income', 'color' => '#10B981', 'icon' => '🔧'],
                    ['name' => 'Investimentos', 'type' => 'income', 'color' => '#10B981', 'icon' => '📈'],
                    
                    // Despesas
                    ['name' => 'Matéria-prima', 'type' => 'expense', 'color' => '#EF4444', 'icon' => '📦'],
                    ['name' => 'Transporte', 'type' => 'expense', 'color' => '#EF4444', 'icon' => '🚗'],
                    ['name' => 'Alimentação', 'type' => 'expense', 'color' => '#EF4444', 'icon' => '🍽️'],
                    ['name' => 'Aluguel', 'type' => 'expense', 'color' => '#EF4444', 'icon' => '🏠'],
                    ['name' => 'Utilidades', 'type' => 'expense', 'color' => '#EF4444', 'icon' => '💡'],
                ];


            foreach ($defaultCategories as $category) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $category['name'],
                    'type' => $category['type'],
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                ]);
            }
        }
    }
}
