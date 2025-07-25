@php use App\Enums\UserRole; @endphp

@foreach ($restaurant->users as $user)
    <!-- Modal: Editar Funcionário -->
    <div id="edit-employee-modal-{{ $user->id }}" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50 backdrop-blur-sm">
        <div class="relative w-full max-w-xl max-h-full mx-auto mt-20">
            <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">

                <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                        Editar Funcionário
                    </h3>
                    <button type="button"
                            class="text-zinc-400 hover:text-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-700 dark:hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-hide="edit-employee-modal-{{ $user->id }}">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('owner.employees.update', [$restaurant, $user]) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name-{{ $user->id }}" class="block font-medium text-sm text-zinc-700 dark:text-white">Nome</label>
                        <input type="text" name="name" id="name-{{ $user->id }}" value="{{ $user->name }}" required
                               class="mt-1 w-full rounded-md border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 shadow-sm">
                    </div>

                    <div>
                        <label for="email-{{ $user->id }}" class="block font-medium text-sm text-zinc-700 dark:text-white">Email</label>
                        <input type="email" name="email" id="email-{{ $user->id }}" value="{{ $user->email }}" required
                               class="mt-1 w-full rounded-md border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 shadow-sm">
                    </div>

                    <div>
                        <label for="role-{{ $user->id }}" class="block font-medium text-sm text-zinc-700 dark:text-white">Cargo</label>
                        <select name="role" id="role-{{ $user->id }}" required
                                class="mt-1 w-full rounded-md border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 shadow-sm">
                            <option value="garcom" @selected($user->role->value === 'garcom')>Garçom</option>
                            <option value="caixa" @selected($user->role->value === 'caixa')>Caixa</option>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" id="is_active-{{ $user->id }}"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600"
                            {{ $user->is_active ? 'checked' : '' }}>
                        <label for="is_active-{{ $user->id }}" class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Ativo</label>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" data-modal-hide="edit-employee-modal-{{ $user->id }}"
                                class="px-4 py-2 bg-zinc-300 hover:bg-zinc-400 text-zinc-900 text-sm font-medium rounded dark:bg-zinc-600 dark:text-white dark:hover:bg-zinc-700">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
