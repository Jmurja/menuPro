<x-layouts.app :title="__('Menu')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header Section with Restaurant Branding -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-zinc-900 dark:text-white mb-2">Cardápio</h1>
            <p class="text-zinc-500 dark:text-zinc-400 max-w-2xl mx-auto">Descubra nossa seleção de pratos preparados com ingredientes frescos e de alta qualidade</p>
        </div>

        <!-- Admin Controls -->
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <button data-modal-target="create-menu-modal" data-modal-toggle="create-menu-modal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Adicionar Novo Item
            </button>

            <button data-modal-target="create-category-modal" data-modal-toggle="create-category-modal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                Adicionar Nova Categoria
            </button>
        </div>

        <!-- Menu Categories -->
        @forelse($items as $categoryName => $categoryItems)
            <div class="mb-16">
                <div class="relative mb-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-zinc-200 dark:border-zinc-700"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <h2 class="px-6 py-2 text-2xl font-bold text-zinc-900 dark:text-white bg-white dark:bg-zinc-800">
                            {{ $categoryName }}
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categoryItems as $item)
                        <div class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border border-zinc-200 dark:border-zinc-700 flex flex-col h-full">
                            <div class="relative">
                                <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}" type="button" class="w-full">
                                    @if ($item->image_url)
                                        <img class="w-full h-56 object-cover" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                    @else
                                        <div class="flex items-center justify-center h-56 bg-gradient-to-r from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30">
                                            <svg class="w-16 h-16 text-amber-500/70 dark:text-amber-400/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @endif

                                    @if(!$item->is_active)
                                        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            Indisponível
                                        </div>
                                    @endif
                                </button>
                            </div>

                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ $item->name }}</h3>

                                <p class="text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-2 flex-grow">
                                    {{ $item->description ?: 'Sem descrição disponível' }}
                                </p>

                                <div class="mt-auto">
                                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-4">
                                        R$ {{ number_format($item->price, 2, ',', '.') }}
                                    </p>

                                    <div class="flex flex-wrap gap-2">
                                        <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-500 dark:hover:bg-amber-600 dark:focus:ring-amber-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Detalhes
                                        </button>

                                        <button data-modal-target="edit-modal-{{ $item->id }}" data-modal-toggle="edit-modal-{{ $item->id }}"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700 transition-colors">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </button>

                                        <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este item?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('menu.modal.edit')
                        @include('menu.modal.show')
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-12 text-center border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-center mb-4">
                    <svg class="w-20 h-20 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-zinc-900 dark:text-white mb-2">Nenhum item no cardápio</h3>
                <p class="text-zinc-500 dark:text-zinc-400 mb-6">Adicione itens ao cardápio para que eles apareçam aqui.</p>
                <button data-modal-target="create-menu-modal" data-modal-toggle="create-menu-modal"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Adicionar Primeiro Item
                </button>
            </div>
        @endforelse
    </div>

    @include('menu.modal.createItem')
    @include('menu.modal.createCategory')
    @vite(['resources/js/validate-menu-create.js', 'resources/js/modal-validation.js'])
</x-layouts.app>
