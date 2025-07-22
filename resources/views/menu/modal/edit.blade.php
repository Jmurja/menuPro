<!-- Edit Modal -->
<div id="edit-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
            <!-- Botão de Fechar -->
            <button type="button"
                    class="absolute top-3 end-2.5 text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white"
                    data-modal-hide="edit-modal-{{ $item->id }}">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="sr-only">Fechar</span>
            </button>

            <!-- Formulário -->
            <form action="{{ route('menu.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Editar Item</h3>

                <!-- Nome -->
                <div>
                    <label for="name-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nome</label>
                    <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" required
                           class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Descrição</label>
                    <textarea name="description" id="description-{{ $item->id }}" rows="3"
                              class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">{{ $item->description }}</textarea>
                </div>

                <!-- Preço -->
                <div>
                    <label for="price-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Preço</label>
                    <input type="number" step="0.01" name="price" id="price-{{ $item->id }}" value="{{ $item->price }}" required
                           class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

                <!-- Imagem -->
                <div>
                    <label for="image-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Imagem (opcional)</label>
                    <input type="file" name="image" id="image-{{ $item->id }}"
                           class="mt-1 block w-full text-sm text-zinc-900 dark:text-zinc-100 file:bg-zinc-100 file:border-none file:rounded file:px-4 file:py-2 file:mr-4 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200">
                </div>

                <!-- Status (Ativo/Inativo) -->
                <div>
                    <label for="is_active-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                    <select name="is_active" id="is_active-{{ $item->id }}"
                           class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="1" {{ $item->is_active ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>

                <!-- Estoque -->
                <div>
                    <label for="stock_quantity-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Quantidade em Estoque (opcional)</label>
                    <input type="number" name="stock_quantity" id="stock_quantity-{{ $item->id }}" min="0" value="{{ $item->stock_quantity }}"
                           class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

                <!-- Horário de Disponibilidade -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="availability_start_time-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Horário de Início (opcional)</label>
                        <input type="time" name="availability_start_time" id="availability_start_time-{{ $item->id }}"
                               value="{{ $item->availability_start_time ? \Carbon\Carbon::parse($item->availability_start_time)->format('H:i') : '' }}"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>
                    <div>
                        <label for="availability_end_time-{{ $item->id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Horário de Término (opcional)</label>
                        <input type="time" name="availability_end_time" id="availability_end_time-{{ $item->id }}"
                               value="{{ $item->availability_end_time ? \Carbon\Carbon::parse($item->availability_end_time)->format('H:i') : '' }}"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>
                </div>

                <!-- Ações -->
                <div class="flex justify-end gap-2">
                    <button data-modal-hide="edit-modal-{{ $item->id }}" type="button"
                            class="px-4 py-2 text-sm font-medium bg-zinc-300 rounded hover:bg-zinc-400 text-zinc-900 dark:bg-zinc-600 dark:text-white dark:hover:bg-zinc-700">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Salvar
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Edit Modal -->
