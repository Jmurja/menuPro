@php use App\Enums\UserRole; @endphp
@foreach ($users as $user)
    <!-- Edit Modal -->
    <div id="edit-modal-{{ $user->id }}" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm">
        <div class="relative w-full max-w-xl max-h-full mx-auto mt-20">
            <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">

                <!-- Botão de Fechar -->
                <button type="button"
                        class="absolute top-3 end-2.5 text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white"
                        data-modal-hide="edit-modal-{{ $user->id }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>

                <!-- Formulário -->
                <form action="{{ route('users.update', $user) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Editar Usuário</h3>

                    <div>
                        <label for="name-{{ $user->id }}"
                               class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nome</label>
                        <input type="text" name="name" id="name-{{ $user->id }}" value="{{ $user->name }}" required
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label for="email-{{ $user->id }}"
                               class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                        <input type="email" name="email" id="email-{{ $user->id }}" value="{{ $user->email }}" required
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label for="phone-{{ $user->id }}"
                               class="block mb-1 font-medium text-zinc-700 dark:text-white">Telefone</label>
                        <input type="text" name="phone" id="phone-{{ $user->id }}" value="{{ $user->phone }}"
                               class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label for="role-{{ $user->id }}"
                               class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Cargo</label>
                        <select name="role" id="role-{{ $user->id }}"
                                class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            @foreach(UserRole::options() as $option)
                                <option
                                    value="{{ $option['value'] }}" @selected($user->role->value === $option['value'])>
                                    {{ $option['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active-{{ $user->id }}" value="1"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600"
                            {{ $user->is_active ? 'checked' : '' }}>
                        <label for="is_active-{{ $user->id }}" class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">
                            Ativo
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button data-modal-hide="edit-modal-{{ $user->id }}" type="button"
                                class="px-4 py-2 text-sm font-medium bg-zinc-300 rounded hover:bg-zinc-400 text-zinc-900 dark:bg-zinc-600 dark:text-white dark:hover:bg-zinc-700">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
