@php use App\Enums\UserRole; @endphp
<x-layouts.app :title="__('Usuários')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Usuários</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <form method="GET" action="{{ route('users.index') }}" class="w-full max-w-xl">
                <div class="flex items-center gap-2">
                    <div class="relative w-full">
                        <input type="search" id="search" name="search" value="{{ request('search') }}"
                               class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Buscar por nome, email ou cargo...">
                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                            </svg>
                        </div>
                    </div>
                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('users.index') }}"
                           class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-zinc-800 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-700 dark:hover:border-zinc-600 dark:focus:ring-zinc-700">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
            <button data-modal-target="create-user-modal" data-modal-toggle="create-user-modal"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                Adicionar Novo Usuário
            </button>
        </div>
    @if ($users->isEmpty())
            <p class="text-zinc-500 dark:text-zinc-400">Nenhum usuário cadastrado.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left text-zinc-500 dark:text-zinc-400">
                    <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Cargo</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->role?->label() }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2 items-center">
                                    <button type="button"
                                            data-modal-target="edit-modal-{{ $user->id }}"
                                            data-modal-toggle="edit-modal-{{ $user->id }}"
                                            class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Editar
                                    </button>
                                    @if ($user->id !== auth()->user()->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                Excluir
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @include('users.modal.create')
    @include('users.modal.edit')
</x-layouts.app>
