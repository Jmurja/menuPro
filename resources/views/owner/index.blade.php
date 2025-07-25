<x-layouts.app :title="__('Meus Restaurantes')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Painel do Proprietário</h1>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($restaurants->isEmpty())
            <div class="text-center py-20">
                <p class="text-zinc-500 dark:text-zinc-400 text-lg">Você ainda não está vinculado a nenhum restaurante.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg shadow-md border dark:border-zinc-700">
                <table class="min-w-full table-auto text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead class="text-xs uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Nome</th>
                        <th class="px-6 py-4">Cidade</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <td class="px-6 py-4 font-medium">{{ $restaurant->name }}</td>
                            <td class="px-6 py-4">{{ $restaurant->city ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $restaurant->state ?? '-' }}</td>
                            <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                                  : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="5" />
                                        </svg>
                                        {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('my_restaurants.show', $restaurant) }}"
                                   class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Detalhes
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
