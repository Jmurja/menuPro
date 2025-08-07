<!-- Modal de Criação de Restaurante -->
<div id="create-restaurant-modal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50">
    <div class="relative w-full max-w-2xl max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                    Novo Restaurante
                </h3>
                <button type="button"
                        class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white p-1.5 rounded-lg"
                        data-modal-hide="create-restaurant-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <form action="{{ route('restaurants.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block mb-1 font-medium text-zinc-700 dark:text-white">Nome do Restaurante *</label>
                        <input type="text" name="name" id="name" required placeholder="Restaurante"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>
                  <div>
                    <label for="cnpj" class="block mb-1 font-medium text-zinc-700 dark:text-white">CNPJ</label>
                    <input type="text" name="cnpj" id="cnpj" maxlength="18"
                           class="cnpj-mask mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                           placeholder="00.000.000/0000-00">
                  </div>

                  <div>
                    <label for="phone" class="block mb-1 font-medium text-zinc-700 dark:text-white">Telefone</label>
                    <input type="text" name="phone" id="phone"
                           class="phone-mask mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                           placeholder="(00) 00000-0000">
                  </div>

                    <div>
                        <label for="zip_code" class="block mb-1 font-medium text-zinc-700 dark:text-white">CEP</label>
                        <input type="text" name="zip_code" id="zip_code" maxlength="9" placeholder="00000-000"
                               class="cep-mask mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label for="street" class="block mb-1 font-medium text-zinc-700 dark:text-white">Rua</label>
                        <input type="text" name="street" id="street" placeholder="Rua"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="number" class="block mb-1 font-medium text-zinc-700 dark:text-white">Número</label>
                            <input type="text" name="number" id="number" placeholder="000"
                                   class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div>
                            <label for="complement" class="block mb-1 font-medium text-zinc-700 dark:text-white">Complemento</label>
                            <input type="text" name="complement" id="complement" placeholder="Complemento"
                                   class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label for="neighborhood" class="block mb-1 font-medium text-zinc-700 dark:text-white">Bairro</label>
                        <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block mb-1 font-medium text-zinc-700 dark:text-white">Cidade</label>
                            <input type="text" name="city" id="city" placeholder="Cidade"
                                   class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <div>
                            <label for="state" class="block mb-1 font-medium text-zinc-700 dark:text-white">Estado (UF)</label>
                            <input type="text" name="state" id="state" maxlength="2" placeholder="UF"
                                   class="uppercase mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 input-checkbox"
                               checked>
                        <label for="is_active" class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Ativo</label>
                    </div>

                    <div>
                        <label for="user_id" class="block mb-1 font-medium text-zinc-700 dark:text-white">Usuário Responsável</label>
                        <select name="user_id" id="user_id" required
                                class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            <option value="">Selecione um usuário</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="role" value="dono">

                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Salvar Restaurante
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
