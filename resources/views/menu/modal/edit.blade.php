<!-- Edit Modal -->
<div id="edit-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-3xl max-h-full mx-auto mt-10">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transform transition-all">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Item
                </h3>
                <button type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-700 dark:hover:text-white transition-colors" data-modal-hide="edit-modal-{{ $item->id }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <!-- Formulário -->
            <div class="p-6">
                <form action="{{ route('menu.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="edit-form-{{ $item->id }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coluna da esquerda -->
                        <div class="space-y-6">
                            <!-- Nome -->
                            <div>
                                <label for="name-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Nome <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" required
                                           class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <div class="mt-1 hidden text-sm text-red-500 name-error-{{ $item->id }}"></div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div>
                                <label for="description-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Descrição</label>
                                <textarea name="description" id="description-{{ $item->id }}" rows="3"
                                          class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">{{ $item->description }}</textarea>
                            </div>

                            <!-- Preço -->
                            <div>
                                <label for="price-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Preço (R$) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="price" id="price-{{ $item->id }}" value="{{ number_format($item->price, 2, ',', '.') }}" required
                                           class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <div class="mt-1 hidden text-sm text-red-500 price-error-{{ $item->id }}"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna da direita -->
                        <div class="space-y-6">
                            <!-- Imagem -->
                            <div>
                                <label for="image-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Imagem (opcional)</label>
                                <div class="flex flex-col items-center justify-center w-full">
                                    <div id="image-preview-{{ $item->id }}" class="mb-3 w-full h-48 bg-zinc-100 dark:bg-zinc-700 rounded-lg overflow-hidden flex items-center justify-center {{ $item->image_url ? '' : 'hidden' }}">
                                        <img id="preview-img-{{ $item->id }}" src="{{ $item->image_url ?? '#' }}" alt="Preview" class="w-full h-full object-contain">
                                    </div>
                                    <label for="image-{{ $item->id }}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-zinc-300 border-dashed rounded-lg cursor-pointer bg-zinc-50 dark:hover:bg-zinc-700 dark:bg-zinc-800 hover:bg-zinc-100 dark:border-zinc-600 dark:hover:border-zinc-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400"><span class="font-semibold">Clique para trocar</span> ou arraste e solte</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG ou WEBP (MAX. 2MB)</p>
                                        </div>
                                        <input type="file" name="image" id="image-{{ $item->id }}" accept="image/*" class="hidden" />
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Status (Ativo/Inativo) -->
                                <div>
                                    <label for="is_active-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Status</label>
                                    <select name="is_active" id="is_active-{{ $item->id }}"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                        <option value="1" {{ $item->is_active ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                </div>

                                <!-- Estoque -->
                                <div>
                                    <label for="stock_quantity-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Estoque (opcional)</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity-{{ $item->id }}" min="0" value="{{ $item->stock_quantity }}" placeholder="Quantidade"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Horário de Disponibilidade -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="availability_start_time-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Horário de Início</label>
                                    <input type="time" name="availability_start_time" id="availability_start_time-{{ $item->id }}"
                                           value="{{ $item->availability_start_time ? \Carbon\Carbon::parse($item->availability_start_time)->format('H:i') : '' }}"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="availability_end_time-{{ $item->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Horário de Término</label>
                                    <input type="time" name="availability_end_time" id="availability_end_time-{{ $item->id }}"
                                           value="{{ $item->availability_end_time ? \Carbon\Carbon::parse($item->availability_end_time)->format('H:i') : '' }}"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="flex items-center justify-end pt-6 space-x-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button data-modal-hide="edit-modal-{{ $item->id }}" type="button"
                                class="px-5 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition-colors dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Modal -->
