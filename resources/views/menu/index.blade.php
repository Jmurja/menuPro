<x-layouts.app :title="__('Menu')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Cardápio</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('menu.show', $item->id) }}">
                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $item->image_url ?? asset('images/placeholder.png') }}" alt="{{ $item->name }}">
                    </a>
                    <div class="p-5">
                        <a href="{{ route('menu.show', $item->id) }}">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->name }}</h5>
                        </a>
                        <p class="mb-3 text-gray-700 dark:text-gray-400">{{ $item->description }}</p>
                        <p class="mb-4 text-lg font-semibold text-green-700 dark:text-green-400">R$ {{ number_format($item->price, 2, ',', '.') }}</p>
                        <a href="{{ route('menu.show', $item->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Ver detalhes
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Nenhum item no cardápio.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
