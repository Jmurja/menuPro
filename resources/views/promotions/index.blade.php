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
                                    <td class="px-6 py-4 text-right space-x-1">
                                        <a href="{{ route('promotions.edit', $promotion->id) }}" class="inline-flex items-center p-2 rounded-md text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-zinc-700" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="sr-only">Editar</span>
                                        </a>
                                        <button type="button" data-modal-target="delete-promotion-modal-{{ $promotion->id }}" data-modal-toggle="delete-promotion-modal-{{ $promotion->id }}" class="inline-flex items-center p-2 rounded-md text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-zinc-700" title="Excluir">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="sr-only">Excluir</span>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Delete Promotion Modal -->
                                <div id="delete-promotion-modal-{{ $promotion->id }}" tabindex="-1" aria-hidden="true"
                                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50 backdrop-blur-sm">
                                    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
                                        <div class="relative bg-white rounded-xl shadow-lg dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transform transition-all">
                                            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Excluir Promoção
                                                </h3>
                                                <button type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-700 dark:hover:text-white transition-colors" data-modal-hide="delete-promotion-modal-{{ $promotion->id }}">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>

                                            <div class="p-6">
                                                <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-6">
                                                    Tem certeza que deseja excluir a promoção <span class="font-semibold">{{ $promotion->name }}</span>?
                                                </p>
                                                <div class="flex items-center justify-between pt-2 space-x-4">
                                                    <button type="button" data-modal-hide="delete-promotion-modal-{{ $promotion->id }}"
                                                            class="flex-1 px-4 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-lg transition-colors dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                            Confirmar Exclusão
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
