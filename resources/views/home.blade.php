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
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline float-right">
                Entrar
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l7-7m0 0l-7-7m7 7H3" />
                </svg>
            </a>
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
