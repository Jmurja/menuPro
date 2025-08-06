<x-layouts.app :title="__('Pedidos')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Gerenciar Pedidos</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Visualize e gerencie os pedidos dos clientes</p>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6 border-b border-zinc-200 dark:border-zinc-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="mr-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 rounded-t-lg active" aria-current="page">Pedidos Ativos</a>
                </li>
                <li class="mr-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-transparent hover:text-zinc-600 hover:border-zinc-300 dark:hover:text-zinc-300 rounded-t-lg">Histórico</a>
                </li>
            </ul>
        </div>

        <!-- Active Orders Section -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Pedidos Ativos</h2>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                    <span class="inline-flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Atualização automática
                    </span>
                </div>
            </div>

            <div id="active-orders" class="space-y-6">
                @forelse($orders ?? [] as $order)
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-5 bg-white dark:bg-zinc-800 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-700">
                            <div>
                                <h3 class="text-xl font-semibold text-zinc-800 dark:text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Mesa: {{ $order->table }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    Pedido #{{ $order->id }} • {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Em preparo
                                </span>
                                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Entregar
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4 bg-white dark:bg-zinc-800/50">
                                <ul class="text-sm text-zinc-700 dark:text-zinc-300 divide-y divide-zinc-100 dark:divide-zinc-700">
                                    @foreach($order->items ?? [] as $item)
                                        <li class="py-2 flex justify-between items-center">
                                            <div class="flex items-start">
                                                <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-2 mt-0.5">
                                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $item->quantity }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium">{{ $item->name }}</span>
                                                    @if($item->notes)
                                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $item->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="font-medium text-green-600 dark:text-green-400">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Nenhum pedido ativo</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 max-w-sm">Quando houver pedidos ativos, eles aparecerão aqui para que você possa gerenciá-los.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- New Order Section -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Lançar Novo Pedido</h2>
                <a href="{{ route('menu') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Ver Cardápio
                </a>
            </div>

            <form id="new-order-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="table_number" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Número da Mesa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="table_number" id="table_number" required
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="item_id" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Item <span class="text-red-500">*</span>
                        </label>
                        <select name="item_id" id="item_id" required
                                class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="">Selecione um item</option>
                            @foreach($menuItems ?? [] as $category => $items)
                                <optgroup label="{{ $category }}">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - R$ {{ number_format($item->price, 2, ',', '.') }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Quantidade <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" min="1" value="1" required
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="notes" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">
                            Observações
                        </label>
                        <input type="text" name="notes" id="notes" placeholder="Ex: Sem cebola, bem passado, etc."
                               class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button type="button" id="add-to-cart-btn"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition-colors dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Adicionar ao Pedido
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg transition-colors dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Enviar Pedido
                    </button>
                </div>
            </form>

            <!-- Cart Preview -->
            <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                <h3 class="text-md font-semibold text-zinc-800 dark:text-white mb-4">Itens no Pedido</h3>

                <div id="cart-items" class="space-y-2 mb-4">
                    <div class="text-center text-zinc-500 dark:text-zinc-400 py-4">
                        Nenhum item adicionado ao pedido
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Total:</span>
                    <span class="font-bold text-green-600 dark:text-green-400 text-xl">R$ <span id="cart-total">0,00</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-success" class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 hidden" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">Pedido enviado com sucesso!</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

    @vite('resources/js/waiter-orders.js')
</x-layouts.app>
