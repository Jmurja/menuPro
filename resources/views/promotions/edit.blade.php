<x-layouts.app :title="__('Editar Promoção')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Editar Promoção</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Atualize as informações da promoção</p>
        </div>

        <!-- Flash Messages -->
        @if (session('error'))
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400" role="alert">
                <span class="font-medium">Erro!</span> {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Informações da Promoção</h2>
            </div>

            <form action="{{ route('promotions.update', $promotion->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome da Promoção -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Nome da Promoção <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $promotion->name) }}" required
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Item do Menu -->
                    <div>
                        <label for="menu_item_id" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Item do Menu <span class="text-red-500">*</span>
                        </label>
                        <select name="menu_item_id" id="menu_item_id" required
                                class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="">Selecione um item</option>
                            @foreach($menuItems as $item)
                                <option value="{{ $item->id }}" {{ old('menu_item_id', $promotion->menu_item_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - R$ {{ number_format($item->price, 2, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('menu_item_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                        Descrição
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">{{ old('description', $promotion->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Preço Promocional -->
                    <div>
                        <label for="discount_price" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Preço Promocional (R$)
                        </label>
                        <input type="text" name="discount_price" id="discount_price" value="{{ old('discount_price', $promotion->discount_price) }}" placeholder="0,00"
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Informe o preço com desconto ou deixe em branco para usar percentual</p>
                        @error('discount_price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Percentual de Desconto -->
                    <div>
                        <label for="discount_percentage" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Percentual de Desconto (%)
                        </label>
                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $promotion->discount_percentage) }}" min="0" max="100" step="1"
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Informe o percentual de desconto ou deixe em branco para usar preço promocional</p>
                        @error('discount_percentage')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @error('discount')
                    <div class="bg-red-100 text-red-700 p-3 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                        {{ $message }}
                    </div>
                @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data de Início -->
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Data de Início <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" required
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Término -->
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Data de Término <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}" required
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">Ativar promoção</span>
                    </label>
                </div>

                <div class="flex items-center justify-end pt-6 space-x-4 border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('promotions.index') }}"
                       class="px-5 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition-colors dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Atualizar Promoção
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/promotion-form.js')
</x-layouts.app>
