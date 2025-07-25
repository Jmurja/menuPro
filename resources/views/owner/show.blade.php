<x-layouts.app :title="$restaurant->name">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">

            @if (session('success'))
                <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                Painel do Restaurante: {{ $restaurant->name }}
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Aqui você pode visualizar os dados e colaboradores vinculados a este restaurante.
            </p>
        </div>

        {{-- Informações do Restaurante --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white mb-4">Informações</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">CNPJ:</span><br>
                    <span class="font-medium text-zinc-800 dark:text-white">
                        {{ $restaurant->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $restaurant->cnpj) : '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">Cidade/Estado:</span><br>
                    <span class="font-medium text-zinc-800 dark:text-white">
                        {{ $restaurant->city ?? '-' }} / {{ $restaurant->state ?? '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">Status:</span><br>
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                        {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">Endereço:</span><br>
                    <span class="font-medium text-zinc-800 dark:text-white">
                        {{ $restaurant->street ?? '-' }},
                        Nº {{ $restaurant->number ?? '-' }},
                        {{ $restaurant->neighborhood ?? '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">CEP:</span><br>
                    <span class="font-medium text-zinc-800 dark:text-white">
                        {{ $restaurant->zip_code ? preg_replace('/(\d{5})(\d{3})/', '$1-$2', $restaurant->zip_code) : '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-300">Complemento:</span><br>
                    <span class="font-medium text-zinc-800 dark:text-white">
                        {{ $restaurant->complement ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Lista de Funcionários --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Funcionários</h2>
                <button data-modal-target="add-employee-modal" data-modal-toggle="add-employee-modal"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
                    + Adicionar Funcionário
                </button>
            </div>

            @if ($restaurant->users->isEmpty())
                <p class="text-zinc-500 dark:text-zinc-400">Nenhum funcionário vinculado a este restaurante.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-zinc-600 dark:text-zinc-300 table-auto">
                        <thead class="text-xs uppercase bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Nome</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Cargo</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($restaurant->users as $user)
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    {{ $user->role->label() }}
                                </td>
                                <td class="px-4 py-2">
                                        <span class="inline-block px-2 py-1 text-xs rounded font-semibold
                                            {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        @if (Auth::user()->id !== $user->id)
                                        <button type="button"
                                                data-modal-target="edit-employee-modal-{{ $user->id }}"
                                                data-modal-toggle="edit-employee-modal-{{ $user->id }}"
                                                class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Editar
                                        </button>
                                            <form action="{{ route('owner.employees.destroy', [$restaurant, $user]) }}"  method="POST"
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
    </div>
</x-layouts.app>
@include('owner.modal.create-employer')
@include('owner.modal.edit-employee')
