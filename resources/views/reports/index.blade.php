<x-layouts.app :title="__('Relatórios')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Relatórios</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filtros de data -->
        <div class="mb-8 bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 text-zinc-900 dark:text-white">Filtros</h2>
            <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Data Inicial</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                           class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Data Final</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                           class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total de Pedidos -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Total de Pedidos</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalOrders }}</p>
            </div>

            <!-- Receita Total -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Receita Total</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
            </div>

            <!-- Ticket Médio -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Ticket Médio</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                    R$ {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2, ',', '.') : '0,00' }}
                </p>
            </div>
        </div>

        <!-- Gráfico de pedidos por dia -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-zinc-900 dark:text-white">Pedidos por Dia</h2>
            <div class="w-full h-80" id="orders-chart"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Status dos Pedidos -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 text-zinc-900 dark:text-white">Status dos Pedidos</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left text-zinc-500 dark:text-zinc-400">
                        <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Quantidade</th>
                                <th scope="col" class="px-6 py-3">Porcentagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordersByStatus as $status => $count)
                                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                                            {{ $status === 'aberto' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                                            {{ $status === 'aberto' ? 'Aberto' : 'Fechado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $count }}</td>
                                    <td class="px-6 py-4">{{ number_format(($count / $totalOrders) * 100, 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Itens Mais Vendidos -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 text-zinc-900 dark:text-white">Itens Mais Vendidos</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left text-zinc-500 dark:text-zinc-400">
                        <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">Item</th>
                                <th scope="col" class="px-6 py-3">Quantidade</th>
                                <th scope="col" class="px-6 py-3">Receita</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellingItems as $item)
                                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                                    <td class="px-6 py-4">{{ $item->name }}</td>
                                    <td class="px-6 py-4">{{ $item->total_quantity }}</td>
                                    <td class="px-6 py-4">R$ {{ number_format($item->total_revenue, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.ordersByDay = @json($ordersByDay);
    </script>
    @vite(['resources/js/owner-reports.js'])
</x-layouts.app>
