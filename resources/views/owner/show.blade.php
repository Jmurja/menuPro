<x-layouts.app :title="$restaurant->name">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">{{ $restaurant->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-zinc-800 dark:text-zinc-200">
            <div><strong>Cidade:</strong> {{ $restaurant->city ?? '-' }}</div>
            <div><strong>Estado:</strong> {{ $restaurant->state ?? '-' }}</div>
            <div><strong>CEP:</strong> {{ $restaurant->zip_code ?? '-' }}</div>
            <div><strong>Rua:</strong> {{ $restaurant->street ?? '-' }}</div>
            <div><strong>Número:</strong> {{ $restaurant->number ?? '-' }}</div>
            <div><strong>Bairro:</strong> {{ $restaurant->neighborhood ?? '-' }}</div>
            <div><strong>Complemento:</strong> {{ $restaurant->complement ?? '-' }}</div>
            <div><strong>Status:</strong>
                <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                    {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                    {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                </span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('my_restaurants.index') }}"
               class="inline-block mt-4 text-blue-600 dark:text-blue-400 hover:underline">
                ← Voltar para Meus Restaurantes
            </a>
        </div>
    </div>
</x-layouts.app>
