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
            $categories = [
                ['name' => 'Vendas', 'type' => 'income', 'color' => 'green'],
                ['name' => 'Salário', 'type' => 'income', 'color' => 'blue'],
                ['name' => 'Outras Receitas', 'type' => 'income', 'color' => 'teal'],
                ['name' => 'Compras', 'type' => 'expense', 'color' => 'red'],
                ['name' => 'Aluguel', 'type' => 'expense', 'color' => 'yellow'],
                ['name' => 'Transporte', 'type' => 'expense', 'color' => 'purple'],
                ['name' => 'Alimentação', 'type' => 'expense', 'color' => 'orange'],
                ['name' => 'Outras Despesas', 'type' => 'expense', 'color' => 'gray'],
            ];

            foreach ($categories as $category) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $category['name'],
                    'type' => $category['type'],
                    'color' => $category['color'],
                ]);
            }
        }
    }
}
