<x-layouts.public :title="__('Cardápio')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6 text-center">Cardápio</h1>

        {{-- Notification for adding to cart --}}
        <div id="cart-notification" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg hidden z-50">
            Item adicionado ao carrinho!
        </div>

        {{-- Agrupado por categoria --}}
        @forelse($items as $categoryName => $categoryItems)
            <h2 class="text-2xl font-semibold text-zinc-800 dark:text-white mt-10 mb-4">{{ $categoryName }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoryItems as $item)
                    <div class="max-w-sm bg-white border border-zinc-200 rounded-lg shadow-sm dark:bg-zinc-800 dark:border-zinc-700">
                        <div class="w-full">
                            @if ($item->image_url)
                                <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                            @else
                                <div class="flex items-center justify-center h-48 bg-zinc-300 rounded-t-sm dark:bg-zinc-700">
                                    <svg class="w-10 h-10 text-zinc-200 dark:text-zinc-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                        <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"/>
                                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $item->name }}</h5>
                            <p class="mb-3 text-zinc-700 dark:text-zinc-400">{{ $item->description }}</p>
                            <p class="mb-4 text-lg font-semibold text-green-700 dark:text-green-400">
                                R$ {{ number_format($item->price, 2, ',', '.') }}
                            </p>
                            <button
                                class="add-to-cart w-full px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-price="{{ $item->price }}">
                                Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-zinc-500 dark:text-zinc-400 text-center">Nenhum item no cardápio.</p>
        @endforelse

        {{-- Cart Button --}}
        <div class="fixed bottom-6 right-6 flex flex-col gap-4">
            <button id="cart-button" class="relative flex items-center justify-center p-4 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center hidden">0</span>
            </button>
        </div>

        {{-- Cart Modal --}}
        <div id="cart-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-md w-full max-h-[80vh] flex flex-col">
                <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 p-4">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">Seu Carrinho</h3>
                    <button id="close-cart" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto p-4 flex-grow">
                    <div id="empty-cart-message" class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                        Seu carrinho está vazio
                    </div>
                    <div id="cart-items" class="space-y-3"></div>
                </div>

                <div class="border-t border-zinc-200 dark:border-zinc-700 p-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-zinc-900 dark:text-white">Total:</span>
                        <span id="cart-total" class="font-bold text-xl text-green-600 dark:text-green-400">R$ 0,00</span>
                    </div>
                    <button
                        id="finalize-order"
                        data-whatsapp="{{ $whatsappNumber }}"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hidden">
                        Finalizar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/cart.js')
</x-layouts.public>
