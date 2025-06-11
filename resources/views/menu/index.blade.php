<x-layouts.app :title="__('Menu')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Cardápio</h1>

        <button data-modal-target="create-menu-modal" data-modal-toggle="create-menu-modal"
                class="mb-6 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">

            Adicionar Novo Item
        </button>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="max-w-sm bg-white border border-zinc-200 rounded-lg shadow-sm dark:bg-zinc-800 dark:border-zinc-700">
                    <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}" type="button" class="w-full">
                        @if ($item->image_url)
                            <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        @else
                            <div class="flex items-center justify-center h-48 bg-zinc-300 rounded-t-sm dark:bg-zinc-700">
                                <svg class="w-10 h-10 text-zinc-200 dark:text-zinc-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                    <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"/>
                                    <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                                </svg>
                            </div>
                        @endif
                    </button>
                    <div class="p-5">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $item->name }}</h5>
                        <p class="mb-3 text-zinc-700 dark:text-zinc-400">{{ $item->description }}</p>
                        <p class="mb-4 text-lg font-semibold text-green-700 dark:text-green-400">
                            R$ {{ number_format($item->price, 2, ',', '.') }}
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}"
                                    class="inline-flex cursor-pointer items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Detalhes
                            </button>

                            <button data-modal-target="edit-modal-{{ $item->id }}" data-modal-toggle="edit-modal-{{ $item->id }}"
                                    class="inline-flex cursor-pointer items-center px-3 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-600">
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>

                            </button>

                            <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center cursor-pointer px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @include('menu.modal.edit')
                @include('menu.modal.show')
                @include('menu.modal.createItem')
                @vite('resources/js/validate-menu-create.js')

            @empty
                <p class="text-zinc-500 dark:text-zinc-400">Nenhum item no cardápio.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
