<x-layouts.app :title="__('Categorias')">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Gerenciar Categorias</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Crie e gerencie categorias para organizar os itens do seu cardápio</p>
        </div>

        <!-- Admin Controls -->
        <div class="flex flex-wrap justify-start gap-4 mb-10">
            <button data-modal-target="create-category-modal" data-modal-toggle="create-category-modal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Adicionar Nova Categoria
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400" role="alert">
                <span class="font-medium">Sucesso!</span> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400" role="alert">
                <span class="font-medium">Erro!</span> {{ session('error') }}
            </div>
        @endif

        <!-- Categories List -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Categorias</h2>
            </div>

            @if($categories->isEmpty())
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-zinc-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Nenhuma categoria encontrada</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 max-w-md mx-auto mb-6">
                        Você ainda não criou nenhuma categoria. Clique no botão abaixo para criar sua primeira categoria.
                    </p>
                    <button data-modal-target="create-category-modal" data-modal-toggle="create-category-modal"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Criar Primeira Categoria
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-zinc-800 dark:text-zinc-200">
                        <thead class="text-xs uppercase bg-zinc-50 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nome</th>
                                <th scope="col" class="px-6 py-3">Slug</th>
                                <th scope="col" class="px-6 py-3">Itens</th>
                                <th scope="col" class="px-6 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-6 py-4 font-medium">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $category->menuItems->count() }} itens
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button data-modal-target="edit-category-modal-{{ $category->id }}" data-modal-toggle="edit-category-modal-{{ $category->id }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">Editar</button>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta categoria? Todos os itens associados ficarão sem categoria.')" class="font-medium text-red-600 dark:text-red-400 hover:underline">Excluir</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Category Modal -->
                                <div id="edit-category-modal-{{ $category->id }}" tabindex="-1" aria-hidden="true"
                                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50 backdrop-blur-sm">
                                    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
                                        <div class="relative bg-white rounded-xl shadow-lg dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transform transition-all">
                                            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
                                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Editar Categoria
                                                </h3>
                                                <button type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-700 dark:hover:text-white transition-colors" data-modal-hide="edit-category-modal-{{ $category->id }}">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>

                                            <div class="p-6">
                                                <form
                                                    action="{{ route('categories.update', $category->id) }}"
                                                    method="POST"
                                                    class="space-y-6"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-4">
                                                        <label for="edit_category_name_{{ $category->id }}" class="block mb-2 text-sm font-medium text-zinc-700 dark:text-white">Nome da Categoria <span class="text-red-500">*</span></label>
                                                        <div class="relative">
                                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                                </svg>
                                                            </div>
                                                            <input type="text" name="name" id="edit_category_name_{{ $category->id }}" value="{{ $category->name }}" required
                                                                   class="pl-10 block w-full rounded-lg border border-zinc-300 bg-zinc-50 p-2.5 text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center justify-between pt-4 space-x-4">
                                                        <button type="button" data-modal-hide="edit-category-modal-{{ $category->id }}"
                                                                class="flex-1 px-4 py-2.5 text-sm font-medium bg-zinc-200 rounded-lg hover:bg-zinc-300 focus:ring-4 focus:ring-zinc-300 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600 dark:focus:ring-zinc-600 transition-colors">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit"
                                                                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition-colors dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Atualizar Categoria
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Category Modal -->
    @include('menu.modal.createCategory')
</x-layouts.app>
