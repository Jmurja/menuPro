@php use App\Enums\UserRole; @endphp
<x-layouts.app :title="__('Usuários')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Usuários</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <button data-modal-target="create-user-modal" data-modal-toggle="create-user-modal"
                class="mb-6 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
            Adicionar Novo Usuário
        </button>

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
                            <td class="px-6 py-4">{{ UserRole::tryFrom($user->role)?->label() }}</td>
                            <td class="px-6 py-4">
                                @if($user->id !== auth()->user()->id)
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @include('users.modal.create')
</x-layouts.app>
