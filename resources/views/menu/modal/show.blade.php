<div id="modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
            <button type="button"
                    class="absolute top-3 end-2.5 text-zinc-700 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white"
                    data-modal-hide="modal-{{ $item->id }}">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span class="sr-only">Fechar</span>
            </button>

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
