<x-layouts.app :title="$restaurant->name">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('my_restaurants.index') }}" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $restaurant->name }}
                </h1>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Gerencie os dados e colaboradores vinculados a este restaurante.
            </p>

            @if (session('success'))
                <div class="mt-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200 shadow-sm border border-green-200 dark:border-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200 rounded-lg shadow-sm border border-red-200 dark:border-red-800">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Por favor, corrija os seguintes erros:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Informações do Restaurante --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Informações do Restaurante</h2>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('restaurant.hours.edit', $restaurant) }}"
                           class="inline-flex items-center justify-center gap-1.5 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Horários
                        </a>

                        <button type="button"
                                data-modal-target="edit-modal-{{ $restaurant->id }}"
                                data-modal-toggle="edit-modal-{{ $restaurant->id }}"
                                class="inline-flex items-center justify-center gap-1.5 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </button>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium
                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                        <span class="flex w-2 h-2 rounded-full {{ $restaurant->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $restaurant->is_active ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-zinc-50 dark:bg-zinc-800/80 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Informações Básicas</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">CNPJ</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $restaurant->cnpj) : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Telefone</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->phone ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Cidade/Estado</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->city ?? '-' }} / {{ $restaurant->state ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-800/80 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Endereço</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Logradouro</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->street ?? '-' }}, Nº {{ $restaurant->number ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Bairro</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->neighborhood ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-800/80 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Detalhes Adicionais</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">CEP</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->zip_code ? preg_replace('/(\d{5})(\d{3})/', '$1-$2', $restaurant->zip_code) : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Complemento</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {{ $restaurant->complement ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lista de Funcionários --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Funcionários</h2>
                <button data-modal-target="add-employee-modal" data-modal-toggle="add-employee-modal"
                        class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Adicionar Funcionário
                </button>
            </div>

            @if ($restaurant->users->isEmpty())
                <div class="bg-zinc-50 dark:bg-zinc-800/80 rounded-lg p-8 text-center border border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Nenhum funcionário encontrado</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 mb-4">Adicione funcionários para gerenciar seu restaurante.</p>
                    <button data-modal-target="add-employee-modal" data-modal-toggle="add-employee-modal"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Adicionar Primeiro Funcionário
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider hidden md:table-cell">Email</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Cargo</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-800 dark:divide-zinc-700">
                            @foreach ($restaurant->users as $user)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 md:hidden">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell text-zinc-600 dark:text-zinc-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-300">
                                        {{ $user->role->label() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                            <span class="flex w-2 h-2 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex flex-col sm:flex-row gap-2 justify-end">
                                            @if (Auth::user()->id !== $user->id)
                                                <button type="button"
                                                        data-modal-target="edit-employee-modal-{{ $user->id }}"
                                                        data-modal-toggle="edit-employee-modal-{{ $user->id }}"
                                                        class="inline-flex items-center justify-center gap-1.5 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Editar
                                                </button>
                                                <form action="{{ route('owner.employees.destroy', [$restaurant, $user]) }}" method="POST"
                                                      onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center gap-1.5 focus:outline-none text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
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
@include('restaurants.modal.edit', ['restaurants' => [$restaurant], 'users' => $restaurant->users])
