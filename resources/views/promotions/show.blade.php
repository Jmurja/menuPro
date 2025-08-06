<x-layouts.app :title="__('Detalhes da Promoção')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">{{ $promotion->name }}</h1>
                    <p class="text-zinc-500 dark:text-zinc-400">Detalhes da promoção</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('promotions.edit', $promotion->id) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta promoção?')"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800 shadow-sm transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Promotion Details -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Informações da Promoção</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Status</h3>
                            @if($promotion->is_active)
                                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full dark:bg-green-900/30 dark:text-green-400">
                                    Ativa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full dark:bg-red-900/30 dark:text-red-400">
                                    Inativa
                                </span>
                            @endif
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Item do Menu</h3>
                            <p class="text-lg font-medium text-zinc-900 dark:text-white">
                                {{ $promotion->menuItem->name ?? 'Item não encontrado' }}
                            </p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                Preço original: R$ {{ number_format($promotion->menuItem->price ?? 0, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Desconto</h3>
                            @if($promotion->discount_price)
                                <p class="text-lg font-medium text-green-600 dark:text-green-400">
                                    Preço promocional: R$ {{ number_format($promotion->discount_price, 2, ',', '.') }}
                                </p>
                            @endif
                            @if($promotion->discount_percentage)
                                <p class="text-lg font-medium text-blue-600 dark:text-blue-400">
                                    {{ number_format($promotion->discount_percentage, 0) }}% de desconto
                                </p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Período da Promoção</h3>
                            <p class="text-zinc-900 dark:text-white">
                                De {{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}
                            </p>

                            @php
                                $now = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($promotion->start_date);
                                $endDate = \Carbon\Carbon::parse($promotion->end_date);

                                if ($now->lt($startDate)) {
                                    $status = 'Aguardando início';
                                    $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                } elseif ($now->gt($endDate)) {
                                    $status = 'Encerrada';
                                    $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                } else {
                                    $status = 'Em andamento';
                                    $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                }

                                $daysLeft = $now->lte($endDate) ? $now->diffInDays($endDate) : 0;
                            @endphp

                            <div class="mt-2 flex items-center gap-3">
                                <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $status }}
                                </span>

                                @if($now->lte($endDate) && $now->gte($startDate))
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $daysLeft }} {{ $daysLeft == 1 ? 'dia' : 'dias' }} restantes
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($promotion->description)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Descrição</h3>
                                <p class="text-zinc-900 dark:text-white whitespace-pre-line">{{ $promotion->description }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Informações Adicionais</h3>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                <p>Criado em: {{ $promotion->created_at->format('d/m/Y H:i') }}</p>
                                <p>Última atualização: {{ $promotion->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('promotions.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 bg-zinc-100 rounded-lg hover:bg-zinc-200 focus:ring-4 focus:outline-none focus:ring-zinc-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para Lista
            </a>
        </div>
    </div>
</x-layouts.app>
