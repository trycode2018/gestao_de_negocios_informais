{{-- resources/views/categories/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorias') }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Organize suas receitas e despesas por categorias</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cabeçalho com botão Nova Categoria -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900">Suas Categorias</h3>
                <a href="{{ route('categories.create') }}" class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition shadow-md">
                    <i class="fas fa-plus mr-2"></i>Nova Categoria
                </a>
            </div>

            <!-- Lista de Categorias -->
            <div class="bg-white rounded-lg shadow">
                @if($categories->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($categories as $category)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                                <!-- Cabeçalho do Card -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" 
                                             style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                            <span class="text-xl">{{ $category->icon }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $category->name }}</h4>
                                            <span class="text-sm {{ $category->type == 'income' ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                {{ $category->type == 'income' ? 'Receita' : 'Despesa' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Botões de Ação -->
                                    <div class="flex space-x-2">
                                        <!-- Botão Editar -->
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-200 transition"
                                           title="Editar categoria">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        
                                        <!-- Botão Excluir -->
                                        @if($category->transactions_count == 0)
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200 transition"
                                                        title="Excluir categoria"
                                                        onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="w-8 h-8 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center cursor-not-allowed"
                                                  title="Categoria em uso - não pode ser excluída">
                                                <i class="fas fa-trash text-sm"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Informações da Categoria -->
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <span>Transações:</span>
                                        <span class="font-semibold">{{ $category->transactions_count }}</span>
                                    </div>
                                    <div class="mt-1 flex justify-between items-center text-sm text-gray-600">
                                        <span>Cor:</span>
                                        <div class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $category->color }}"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Estado Vazio -->
                    <div class="text-center py-12">
                        <div class="mb-4">
                            <i class="fas fa-tags text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Nenhuma categoria cadastrada</h3>
                        <p class="text-gray-500 mb-6">Comece criando suas categorias para organizar as transações</p>
                        <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center shadow-md">
                            <i class="fas fa-plus mr-2"></i>Criar Primeira Categoria
                        </a>
                    </div>
                @endif
            </div>

            <!-- Dica -->
            @if($categories->count() > 0)
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-800">Dica</h4>
                            <p class="text-blue-700 text-sm mt-1">
                                Crie categorias específicas para suas receitas e despesas. 
                                Isso ajuda a entender melhor para onde seu dinheiro está indo e de onde está vindo.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>