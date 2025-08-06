<x-layouts.app :title="__('Promoções')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Gerenciar Promoções</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Crie e gerencie promoções para os itens do seu cardápio</p>
        </div>

        <!-- Admin Controls -->
        <div class="flex flex-wrap justify-start gap-4 mb-10">
            <a href="{{ route('promotions.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Adicionar Nova Promoção
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400" role="alert">
                <span class="font-medium">Sucesso!</span> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400" role="alert">
                <span class="font-medium">Erro!</span> {{ session('error') }}
            </div>
        @endif

        <!-- Promotions List -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Promoções Ativas</h2>
            </div>

            @if($promotions->isEmpty())
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-zinc-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Nenhuma promoção encontrada</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 max-w-md mx-auto mb-6">
                        Você ainda não criou nenhuma promoção. Clique no botão abaixo para criar sua primeira promoção.
                    </p>
                    <a href="{{ route('promotions.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Criar Primeira Promoção
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-zinc-800 dark:text-zinc-200">
                        <thead class="text-xs uppercase bg-zinc-50 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nome</th>
                                <th scope="col" class="px-6 py-3">Item</th>
                                <th scope="col" class="px-6 py-3">Desconto</th>
                                <th scope="col" class="px-6 py-3">Período</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $promotion)
                                <tr class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-6 py-4 font-medium">
                                        {{ $promotion->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $promotion->menuItem->name ?? 'Item não encontrado' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($promotion->discount_price)
                                            <span class="text-green-600 dark:text-green-400 font-medium">
                                                R$ {{ number_format($promotion->discount_price, 2, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($promotion->discount_percentage)
                                            <span class="text-blue-600 dark:text-blue-400 font-medium">
                                                {{ number_format($promotion->discount_percentage, 0) }}% de desconto
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($promotion->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900/30 dark:text-green-400">
                                                Ativa
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900/30 dark:text-red-400">
                                                Inativa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('promotions.edit', $promotion->id) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">Editar</a>
                                        <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta promoção?')" class="font-medium text-red-600 dark:text-red-400 hover:underline">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
