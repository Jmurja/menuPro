<x-layouts.app :title="__('Novo item')">
    <div class="max-w-xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Adicionar novo item</h1>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>

                <label class="block text-gray-700 dark:text-white">Nome</label>
                <input type="text" name="name" required class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-white">Descrição</label>
                <textarea name="description" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-white">Preço (R$)</label>
                <input type="number" name="price" step="0.01" required class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-white">Imagem (opcional)</label>
                <input type="file" name="image" accept="image/*" class="w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Salvar item
            </button>
        </form>
    </div>
</x-layouts.app>
