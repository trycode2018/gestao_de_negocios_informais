<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Transaction::with('category')
            ->where('user_id', $user->id);
            
        // Filtros
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }
        
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $categories = Category::where('user_id', $user->id)->get();
        
        // Estatísticas para os filtros aplicados
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income');
            
        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense');
            
        // Aplicar mesmos filtros às estatísticas
        if ($request->has('start_date') && $request->start_date) {
            $totalIncome->where('date', '>=', $request->start_date);
            $totalExpense->where('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $totalIncome->where('date', '<=', $request->end_date);
            $totalExpense->where('date', '<=', $request->end_date);
        }
        
        if ($request->has('category_id') && $request->category_id) {
            $totalIncome->where('category_id', $request->category_id);
            $totalExpense->where('category_id', $request->category_id);
        }
        
        $totalIncome = $totalIncome->sum('amount');
        $totalExpense = $totalExpense->sum('amount');
        
        return view('transactions.index', compact(
            'transactions', 
            'categories',
            'totalIncome',
            'totalExpense'
        ));
    }


    /*public function index(Request $request)
    {
        $user = auth()->user();
        $query = Transaction::with('category')
            ->where('user_id', $user->id);
            
        // Filtros
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }
        
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $categories = Category::where('user_id', $user->id)->get();
        
        return view('transactions.index', compact('transactions', 'categories'));
    }*/

    public function create()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'date' => $validated['date'],
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação cadastrada com sucesso!');
    }

    public function edit(Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }
        
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->get();
        
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }
        
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transação excluída com sucesso!');
    }
}