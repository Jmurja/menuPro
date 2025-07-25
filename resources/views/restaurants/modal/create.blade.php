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
                        class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-800 dark:hover:text-white"
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
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium text-zinc-700 dark:text-white">Vincular Usuários</label>
                        <div id="user-role-container" class="space-y-4">
                            <div class="flex items-center gap-4">
                                <select name="users[0][id]" required
                                        class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="">Selecione um usuário</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <select name="users[0][role]" required
                                        class="w-48 rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="dono">Dono</option>
                                    <option value="garcom">Garçom</option>
                                    <option value="caixa">Caixa</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" id="add-user-role"
                                class="mt-3 inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            + Adicionar Usuário
                        </button>
                    </div>

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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('add-user-role');
            const container = document.getElementById('user-role-container');
            let index = 1;

            addBtn.addEventListener('click', () => {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-4');

                div.innerHTML = `
                <select name="users[${index}][id]" required
                    class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">Selecione um usuário</option>
                    @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <select name="users[${index}][role]" required
                    class="w-48 rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="dono">Dono</option>
                    <option value="garcom">Garçom</option>
                    <option value="caixa">Caixa</option>
                </select>
            `;
                container.appendChild(div);
                index++;
            });
        });
    </script>
@endpush
