<!-- Modal de Edição de Restaurante -->
@foreach($restaurants as $restaurant)
    <div id="edit-modal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50">
        <div class="relative w-full max-w-2xl max-h-full mx-auto mt-20">
            <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
                <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                        Editar Restaurante
                    </h3>
                    <button type="button"
                            class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white p-1.5 rounded-lg"
                            data-modal-hide="edit-modal-{{ $restaurant->id }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Nome do Restaurante *</label>
                            <input type="text" name="name" id="name-{{ $restaurant->id }}" value="{{ $restaurant->name }}" required
                                   class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div>
                            <label for="city-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Cidade</label>
                            <input type="text" name="city" id="city-{{ $restaurant->id }}" value="{{ $restaurant->city }}"
                                   class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div>
                            <label for="state-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Estado (UF)</label>
                            <input type="text" name="state" id="state-{{ $restaurant->id }}" value="{{ $restaurant->state }}" maxlength="2"
                                   class="uppercase mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active-{{ $restaurant->id }}" value="1"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 input-checkbox"
                                {{ $restaurant->is_active ? 'checked' : '' }}>
                            <label for="is_active-{{ $restaurant->id }}" class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Ativo</label>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-zinc-700 dark:text-white">Responsável</label>
                            <input type="text" disabled
                                   value="{{ $restaurant->users->first()->name ?? 'Nenhum usuário vinculado' }}"
                                   class="block w-full bg-gray-100 dark:bg-zinc-700 rounded-md border-zinc-300 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                Atualizar Restaurante
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
