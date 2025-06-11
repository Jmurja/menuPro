<div id="modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
            <button type="button"
                    class="absolute top-3 end-2.5 text-zinc-700 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white"
                    data-modal-hide="modal-{{ $item->id }}"
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
                        class="text-white bg-zinc-700 cursor-pointer hover:bg-zinc-800 focus:ring-4 focus:outline-none focus:ring-zinc-500 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-zinc-600 dark:hover:bg-zinc-700">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
