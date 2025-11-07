{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Visão geral do seu negócio</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Receitas do Mês -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-money-bill-wave text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Receitas do Mês</p>
                            <p class="text-2xl font-bold text-green-600">R$ {{ number_format($monthlyIncome, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Despesas do Mês -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Despesas do Mês</p>
                            <p class="text-2xl font-bold text-red-600">R$ {{ number_format($monthlyExpense, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Saldo do Mês -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Saldo do Mês</p>
                            <p class="text-2xl font-bold {{ $monthlyBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                R$ {{ number_format($monthlyBalance, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Transações Recentes -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Transações Recentes</h2>
                    </div>
                    <div class="p-6">
                        @if($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTransactions as $transaction)
                                    <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" 
                                                 style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }};">
                                                <span class="text-lg">{{ $transaction->category->icon }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $transaction->description }}</p>
                                                <p class="text-sm text-gray-500">{{ $transaction->category->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type == 'income' ? '+' : '-' }} R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Ver todas as transações
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-exchange-alt text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">Nenhuma transação cadastrada ainda</p>
                                <a href="{{ route('transactions.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    Cadastrar Primeira Transação
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Categorias Mais Usadas -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Categorias Mais Usadas</h2>
                    </div>
                    <div class="p-6">
                        @if($topCategories->count() > 0)
                            <div class="space-y-3">
                                @foreach($topCategories as $category)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" 
                                                 style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                                <span class="text-sm">{{ $category->icon }}</span>
                                            </div>
                                            <span class="font-medium text-gray-700">{{ $category->name }}</span>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $category->recent_count }} transações</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Gerenciar categorias
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-tags text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">Nenhuma categoria cadastrada</p>
                                <a href="{{ route('categories.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    Criar Primeira Categoria
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>