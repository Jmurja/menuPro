<x-layouts.app :title="__('Caixa')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Controle de Mesas</h1>

        @forelse($orders as $table => $tableOrders)
            <div class="mb-8 border border-zinc-300 dark:border-zinc-700 rounded-lg p-4 bg-white dark:bg-zinc-800">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Mesa: {{ $table }}</h2>

                    <form method="POST" action="{{ route('cashier.close') }}">
                        @csrf
                        <input type="hidden" name="table" value="{{ $table }}">
                        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Fechar Conta
                        </button>
                    </form>
                </div>

                <div class="space-y-4">
                    @foreach($tableOrders as $order)
                        <div class="border border-zinc-200 dark:border-zinc-600 rounded p-3">
                            <p class="text-sm text-zinc-500 dark:text-zinc-300">Pedido #{{ $order->id }} - {{ $order->created_at->format('H:i') }}</p>
                            <ul class="list-disc pl-5 text-sm mt-2 text-zinc-700 dark:text-zinc-300">
                                @foreach($order->items as $item)
                                    <li>{{ $item->menuItem->name }} x{{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma mesa com pedidos em aberto.</p>
        @endforelse
    </div>
</x-layouts.app>
