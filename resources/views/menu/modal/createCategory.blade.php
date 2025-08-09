<!-- Modal de Criação de Categoria -->
<div id="create-category-modal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transform transition-all">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Adicionar Nova Categoria
                </h3>
                <button type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-700 dark:hover:text-white transition-colors" data-modal-hide="create-category-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <form
                    id="create-category-form"
                    action="{{ route('categories.store') }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf

                    <div class="mb-4">
                        <label for="category_name" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Nome da Categoria <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="category_name" required
                                   class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <div class="mt-1 hidden text-sm text-red-500 category-error"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="category_icon" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Ícone da Categoria</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select name="icon" id="category_icon" class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <option value="🍽️">🍽️ Prato</option>
                                    <option value="🍔">🍔 Hambúrguer</option>
                                    <option value="🍕">🍕 Pizza</option>
                                    <option value="🍣">🍣 Sushi</option>
                                    <option value="🍝">🍝 Massa</option>
                                    <option value="🥗">🥗 Salada</option>
                                    <option value="🍰">🍰 Sobremesa</option>
                                    <option value="🍹">🍹 Bebida</option>
                                    <option value="☕">☕ Café</option>
                                    <option value="🍺">🍺 Cerveja</option>
                                    <option value="🍷">🍷 Vinho</option>
                                    <option value="🔥">🔥 Destaque</option>
                                </select>
                            </div>
                            <div>
                                <input type="text" name="custom_icon" id="custom_icon" placeholder="Ou digite um emoji personalizado"
                                       class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Selecione um ícone predefinido ou digite um emoji personalizado</p>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="is_offer" id="is_offer" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="is_offer" class="ml-2 text-sm font-medium text-zinc-700 dark:text-white">Esta categoria é de ofertas/combos</label>
                        </div>

                        <div id="offer_type_container" class="mt-3 hidden">
                            <label for="offer_type" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Tipo de Oferta</label>
                            <select name="offer_type" id="offer_type" class="block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                <option value="ofertas">Ofertas</option>
                                <option value="combos">Combos</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 space-x-4">
                        <button type="button" data-modal-hide="create-category-modal"
                                class="flex-1 px-4 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition-colors dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Salvar Categoria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle offer type dropdown visibility based on checkbox
        const isOfferCheckbox = document.getElementById('is_offer');
        const offerTypeContainer = document.getElementById('offer_type_container');

        isOfferCheckbox.addEventListener('change', function() {
            if (this.checked) {
                offerTypeContainer.classList.remove('hidden');
            } else {
                offerTypeContainer.classList.add('hidden');
            }
        });

        // Handle custom icon and dropdown selection
        const iconDropdown = document.getElementById('category_icon');
        const customIconInput = document.getElementById('custom_icon');

        customIconInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                // If custom icon is entered, reset dropdown
                iconDropdown.selectedIndex = 0;
            }
        });

        iconDropdown.addEventListener('change', function() {
            if (this.value !== '') {
                // If dropdown is selected, clear custom icon
                customIconInput.value = '';
            }
        });
    });
</script>
