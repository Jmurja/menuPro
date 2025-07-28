<x-layouts.app :title="__('Pedidos')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Lançar Pedido</h1>

        @forelse($items as $categoryName => $categoryItems)
            <h2 class="text-2xl font-semibold text-zinc-800 dark:text-white mt-10 mb-4">{{ $categoryName }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoryItems as $item)
                    <div class="max-w-sm bg-white border border-zinc-200 rounded-lg shadow-sm dark:bg-zinc-800 dark:border-zinc-700">
                        @if ($item->image_url)
                            <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        @endif

                        <div class="p-5">
                            <h5 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $item->name }}</h5>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">{{ $item->description }}</p>
                            <p class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">
                                R$ {{ number_format($item->price, 2, ',', '.') }}
                            </p>

                            {{-- Botão adicionar ao carrinho --}}
                            <button
                                data-add-to-cart
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-price="{{ $item->price }}"
                                class="w-full px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Adicionar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-zinc-500 dark:text-zinc-400">Nenhum item disponível no momento.</p>
        @endforelse
    </div>

    {{-- Carrinho flutuante --}}
    <div id="cart" class="fixed bottom-4 right-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-lg rounded-lg w-80 p-4 hidden transition-all duration-300">
        <h2 class="text-xl font-bold mb-3 text-zinc-800 dark:text-white">Carrinho</h2>
        <ul id="cart-items" class="space-y-2 text-sm text-zinc-700 dark:text-zinc-300 max-h-48 overflow-y-auto pr-1"></ul>

        <div class="mt-4">
            <label for="table" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Mesa:</label>
            <input type="text" id="table" name="table" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
        </div>

        <p class="mt-4 font-semibold text-green-700 dark:text-green-400 text-right">
            Total: R$ <span id="cart-total">0,00</span>
        </p>

        <button onclick="submitOrder()" class="mt-4 w-full px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
            Enviar Pedido
        </button>
    </div>

    {{-- Toast de confirmação --}}
    <div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 hidden bg-green-600 text-white px-4 py-2 rounded-lg shadow-md">
        Pedido enviado com sucesso!
    </div>

</x-layouts.app>

@vite('resources/js/cart.js')
