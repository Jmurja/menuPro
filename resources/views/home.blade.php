<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>MenuPro - Escolha um Restaurante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<body class="bg-gray-100 text-gray-800">

    <header class="bg-white shadow-md py-4">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-2xl font-bold">🍽️ MenuPro</h1>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-bold mb-6">Escolha um restaurante</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($restaurants as $restaurant)
                <a href="{{ route('menu.public', $restaurant->id) }}"
                   class="bg-white p-5 rounded-lg shadow hover:shadow-md transition block">
                    <h3 class="text-xl font-semibold mb-1">{{ $restaurant->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $restaurant->city ?? 'Cidade não informada' }}</p>
                </a>
            @empty
                <div class="col-span-full text-gray-500">
                    Nenhum restaurante cadastrado.
                </div>
            @endforelse
        </div>
    </main>

    <footer class="text-center py-6 text-sm text-gray-500">
        &copy; {{ date('Y') }} MenuPro. Todos os direitos reservados.
    </footer>

</body>
</html>
