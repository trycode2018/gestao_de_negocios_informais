<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)
            ->withCount('transactions') // Isso conta as transações relacionadas
            ->orderBy('type')
            ->orderBy('name')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'color' => $validated['color'],
            'icon' => $validated['icon'],
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Category $category)
    {
        // Verificar se a categoria pertence ao usuário
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Verificar se a categoria pertence ao usuário
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        // Verificar se a categoria pertence ao usuário
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        
        // Verificar se existem transações associadas
        if ($category->transactions()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Não é possível excluir uma categoria com transações associadas.');
        }
        
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}