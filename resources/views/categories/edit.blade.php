{{-- resources/views/categories/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoria') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Vendas">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo *</label>
                            <select name="type" id="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione o tipo</option>
                                <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Receita</option>
                                <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cor -->
                        <div class="mb-4">
                            <label for="color" class="block text-sm font-medium text-gray-700">Cor *</label>
                            <div class="flex items-center space-x-4">
                                <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}" required 
                                       class="w-16 h-16 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <div class="text-sm text-gray-500">
                                    Escolha uma cor para identificar a categoria
                                </div>
                            </div>
                            @error('color')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ícone -->
                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700">Ícone *</label>
                            <div class="grid grid-cols-8 gap-2 mb-2">
                                @php
                                    $defaultIcons = ['💰', '🛒', '🍽️', '🚗', '🏠', '💡', '📦', '🔧', '👕', '📱', '💊', '🎓', '✈️', '🎁', '💳', '📊'];
                                @endphp
                                @foreach($defaultIcons as $icon)
                                    <button type="button" class="icon-option w-10 h-10 border border-gray-300 rounded-md hover:border-blue-500 focus:border-blue-500 text-lg" data-icon="{{ $icon }}">
                                        {{ $icon }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Emoji ou ícone">
                            @error('icon')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Atualizar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Seleção de ícones
        document.querySelectorAll('.icon-option').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('icon').value = this.getAttribute('data-icon');
                
                // Remove highlight from all buttons
                document.querySelectorAll('.icon-option').forEach(btn => {
                    btn.classList.remove('border-blue-500', 'bg-blue-50');
                });
                
                // Add highlight to selected button
                this.classList.add('border-blue-500', 'bg-blue-50');
            });
        });

        // Highlight the current icon on load
        document.addEventListener('DOMContentLoaded', function() {
            const currentIcon = document.getElementById('icon').value;
            document.querySelectorAll('.icon-option').forEach(button => {
                if (button.getAttribute('data-icon') === currentIcon) {
                    button.classList.add('border-blue-500', 'bg-blue-50');
                }
            });
        });
    </script>
</x-app-layout>