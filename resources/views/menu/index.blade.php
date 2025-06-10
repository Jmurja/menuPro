<x-layouts.app :title="__('Menu')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Cardápio</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="max-w-sm bg-white border border-zinc-200 rounded-lg shadow-sm dark:bg-zinc-800 dark:border-zinc-700">
                    <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}" type="button" class="w-full">
                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $item->image_url ?? asset('images/placeholder.png') }}" alt="{{ $item->name }}">
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
                                Editar
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
                <!-- Modal -->
                <div id="modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 backdrop-blur-sm">
                    <div class="relative w-full max-w-xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
                            <button type="button"
                                    class="absolute top-3 end-2.5 text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white"
                                    data-modal-hide="modal-{{ $item->id }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="sr-only">Fechar</span>
                            </button>

                            <img class="w-full h-72 object-cover rounded-t-lg" src="{{ $item->image_url ?? asset('images/placeholder.png') }}" alt="{{ $item->name }}">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">{{ $item->name }}</h3>
                                @if($item->description)
                                    <p class="text-zinc-700 dark:text-zinc-400 mb-4">{{ $item->description }}</p>
                                @endif
                                <p class="text-lg font-semibold text-green-700 dark:text-green-400 mb-6">
                                    R$ {{ number_format($item->price, 2, ',', '.') }}
                                </p>
                                <button data-modal-hide="modal-{{ $item->id }}" type="button"
                                        class="text-white bg-zinc-700 hover:bg-zinc-800 focus:ring-4 focus:outline-none focus:ring-zinc-500 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-zinc-600 dark:hover:bg-zinc-700">
                                    Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Modal -->

            @empty
                <p class="text-zinc-500 dark:text-zinc-400">Nenhum item no cardápio.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
