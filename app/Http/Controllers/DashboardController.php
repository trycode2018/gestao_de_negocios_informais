<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Estatísticas básicas
        $today = now()->format('Y-m-d');
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');
        
        // Total do mês
        $monthlyIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $monthlyExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $monthlyBalance = $monthlyIncome - $monthlyExpense;
        
        // Transações recentes
        $recentTransactions = Transaction::with('category')
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Gráfico simples - últimos 7 dias
        $weeklyData = Transaction::where('user_id', $user->id)
            ->where('date', '>=', now()->subDays(7)->format('Y-m-d'))
            ->select('date', 'type', DB::raw('SUM(amount) as total'))
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get();
            
        // Categorias mais usadas
        $topCategories = Category::where('user_id', $user->id)
            ->withCount(['transactions as recent_count' => function($query) {
                $query->where('date', '>=', now()->subDays(30)->format('Y-m-d'));
            }])
            ->orderBy('recent_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'monthlyIncome',
            'monthlyExpense', 
            'monthlyBalance',
            'recentTransactions',
            'weeklyData',
            'topCategories'
        ));
    }
}