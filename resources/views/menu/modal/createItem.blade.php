<!-- Modal de Criação -->
<div id="create-menu-modal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-3xl max-h-full mx-auto mt-10">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transform transition-all">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Adicionar Novo Item
                </h3>
                <button type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-700 dark:hover:text-white transition-colors" data-modal-hide="create-menu-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <form
                    id="create-menu-item-form"
                    action="{{ route('menu.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coluna da esquerda -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Nome <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name" id="name" required
                                           class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <div class="mt-1 hidden text-sm text-red-500 name-error"></div>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Descrição</label>
                                <textarea name="description" id="description" rows="3"
                                          class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"></textarea>
                            </div>

                            <div>
                                <label for="category_id" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Categoria <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <select name="category_id" id="category_id" required
                                            class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                        <option value="">Selecione uma categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mt-1 hidden text-sm text-red-500 category-error"></div>
                                </div>
                            </div>

                            <div>
                                <label for="price" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Preço (R$) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="price" id="price" required placeholder="0,00"
                                           class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" />
                                    <div class="mt-1 hidden text-sm text-red-500 price-error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna da direita -->
                        <div class="space-y-6">
                            <div>
                                <label for="image" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Imagem (opcional)</label>
                                <div class="flex flex-col items-center justify-center w-full">
                                    <div id="image-preview" class="hidden mb-3 w-full h-48 bg-zinc-100 dark:bg-zinc-700 rounded-lg overflow-hidden flex items-center justify-center">
                                        <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-contain">
                                    </div>
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-zinc-300 border-dashed rounded-lg cursor-pointer bg-zinc-50 dark:hover:bg-zinc-700 dark:bg-zinc-800 hover:bg-zinc-100 dark:border-zinc-600 dark:hover:border-zinc-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400"><span class="font-semibold">Clique para enviar</span> ou arraste e solte</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG ou WEBP (MAX. 2MB)</p>
                                        </div>
                                        <input type="file" name="image" id="image" accept="image/*" class="hidden" />
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="is_active" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Status</label>
                                    <select name="is_active" id="is_active"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                        <option value="1" selected>Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="stock_quantity" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Estoque (opcional)</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" placeholder="Quantidade"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="availability_start_time" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Horário de Início</label>
                                    <input type="time" name="availability_start_time" id="availability_start_time"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="availability_end_time" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Horário de Término</label>
                                    <input type="time" name="availability_end_time" id="availability_end_time"
                                           class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 space-x-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" data-modal-hide="create-menu-modal"
                                class="px-5 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg transition-colors dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Salvar Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
