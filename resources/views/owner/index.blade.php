<x-layouts.app :title="__('Meus Restaurantes')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Painel do Proprietário</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Gerencie seus restaurantes e funcionários</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 shadow-sm border border-green-200 dark:border-green-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($restaurants->isEmpty())
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-10 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Nenhum restaurante encontrado</h3>
                <p class="text-zinc-500 dark:text-zinc-400">Você ainda não está vinculado a nenhum restaurante.</p>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider hidden sm:table-cell">Cidade</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider hidden md:table-cell">Estado</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-800 dark:divide-zinc-700">
                            @foreach ($restaurants as $restaurant)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $restaurant->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell text-zinc-600 dark:text-zinc-300">
                                        {{ $restaurant->city ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell text-zinc-600 dark:text-zinc-300">
                                        {{ $restaurant->state ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                                                                      : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                            <span class="flex w-2 h-2 rounded-full {{ $restaurant->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('my_restaurants.show', $restaurant) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:bg-blue-900/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Detalhes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
