<x-layouts.app :title="__('Novo item')">
    <div class="max-w-2xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-extrabold mb-8 text-zinc-900 dark:text-white">Adicionar Novo Item</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded bg-red-100 text-red-700 border border-red-400 dark:bg-red-200 dark:text-red-900">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('menu.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-md"
        >
            @csrf

            {{-- Nome --}}
            <div>
                <label for="name" class="block mb-1 font-medium text-zinc-700 dark:text-white">Nome *</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:text-white border-zinc-300 focus:ring-2 focus:ring-zinc-500"
                >
            </div>

            {{-- Descrição --}}
            <div>
                <label for="description" class="block mb-1 font-medium text-zinc-700 dark:text-white">Descrição</label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:text-white border-zinc-300 focus:ring-2 focus:ring-zinc-500"
                ></textarea>
            </div>

            {{-- Preço --}}
            <div>
                <label for="price" class="block mb-1 font-medium text-zinc-700 dark:text-white">Preço (R$) *</label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    step="0.01"
                    required
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:text-white border-zinc-300 focus:ring-2 focus:ring-zinc-500"
                >
            </div>

            {{-- Imagem --}}
            <div>
                <label for="image" class="block mb-1 font-medium text-zinc-700 dark:text-white">Imagem (opcional)</label>
                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/*"
                    class="w-full text-zinc-700 dark:text-white"
                >
            </div>

            {{-- Botão --}}
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200"
                >
                    Salvar Item
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
