{{-- resources/views/categories/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Categoria') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cabeçalho da Categoria -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4" 
                                 style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                <span class="text-2xl">{{ $category->icon }}</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                                <p class="text-gray-600">
                                    {{ $category->type == 'income' ? 'Receita' : 'Despesa' }} • 
                                    {{ $category->transactions->count() }} transações
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>
                            <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                <i class="fas fa-arrow-left mr-2"></i>Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transações da Categoria -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Transações desta Categoria</h3>
                </div>
                <div class="p-6">
                    @if($transactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($transactions as $transaction)
                                <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="text-left">
                                            <p class="font-medium text-gray-900">{{ $transaction->description }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction->type == 'income' ? '+' : '-' }} R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </p>
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Ver detalhes
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Paginação -->
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-exchange-alt text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">Nenhuma transação nesta categoria</p>
                            <a href="{{ route('transactions.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Criar Primeira Transação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>