{{-- resources/views/transactions/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Transação') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <!-- Tipo -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo *</label>
                            <select name="type" id="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione o tipo</option>
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Receita</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categoria -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria *</label>
                            <select name="category_id" id="category_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->type == 'income' ? 'Receita' : 'Despesa' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valor -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Valor *</label>
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0,00">
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Venda de produtos">
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Data *</label>
                            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Salvar Transação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filtro dinâmico de categorias baseado no tipo selecionado
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            const categorySelect = document.getElementById('category_id');
            const options = categorySelect.options;
            
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === '') continue;
                
                const categoryType = option.text.includes('Receita') ? 'income' : 'expense';
                option.style.display = type === '' || categoryType === type ? '' : 'none';
            }
            
            // Reset selection if current selection doesn't match type
            if (type !== '' && categorySelect.value !== '') {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const selectedType = selectedOption.text.includes('Receita') ? 'income' : 'expense';
                if (selectedType !== type) {
                    categorySelect.value = '';
                }
            }
        });
    </script>
</x-app-layout>