<x-layouts.app :title="__('Meus Restaurantes')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Meus Restaurantes</h1>

        @if ($restaurants->isEmpty())
            <p class="text-zinc-500 dark:text-zinc-400">Você ainda não está vinculado a nenhum restaurante.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left text-zinc-500 dark:text-zinc-400">
                    <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-200">
                    <tr>
                        <th class="px-6 py-3">Nome</th>
                        <th class="px-6 py-3">Cidade</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-4">{{ $restaurant->name }}</td>
                            <td class="px-6 py-4">{{ $restaurant->city ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $restaurant->state ?? '-' }}</td>
                            <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('my_restaurants.show', $restaurant) }}"
                                   class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                                    Ver Detalhes
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
