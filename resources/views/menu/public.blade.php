<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} - Cardápio Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#4a3d3d',
                        'secondary': '#ff6161',
                        'background': '#f4f8e6',
                        'card-bg': '#f2e9e6',
                        'light-red': '#ffeaea'
                    },
                    keyframes: {
                        fire: {
                            '0%, 100%': { transform: 'scale(1) rotate(-5deg)' },
                            '50%': { transform: 'scale(1.2) rotate(5deg)' }
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    },
                    animation: {
                        fire: 'fire 1s infinite',
                        fadeInUp: 'fadeInUp 1s ease-out forwards'
                    }
                }
            }
        };
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .card-expanded {
            transform: scale(1.05);
            z-index: 10;
            position: relative;
        }
        .card-observacao {
            display: none;
        }
        .card-expanded .card-observacao {
            display: block;
        }
        /* Hamburger/X animation */
        .hamburger span {
            display: block;
            width: 28px;
            height: 3px;
            margin: 6px auto;
            background: #fff;
            border-radius: 2px;
            transition: all 0.3s;
        }
        .hamburger.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }
        /* Modern shadow for cards */
        .modern-shadow {
            box-shadow: 0 4px 24px 0 rgba(255,97,97,0.08), 0 1.5px 6px 0 rgba(74,61,61,0.08);
        }
        /* Red border for ofertas */
        .oferta-card {
            border: 2px solid #ff6161;
            background: #ffeaea;
        }
        /* Book style */
        .book-section {
            border-left: 6px solid #ff6161;
            border-radius: 0 24px 24px 0;
            background: #fff;
            margin-bottom: 2.5rem;
            padding-left: 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(74,61,61,0.04);
        }
        @media (max-width: 640px) {
            .book-section {
                border-left-width: 3px;
                border-radius: 0 12px 12px 0;
                padding-left: 0.75rem;
            }
        }
        /* Ajuste o z-index dos modais para garantir que fiquem sempre na frente */
        #modalSobre,
        #modalHorario,
        #modalCardapio {
            z-index: 9999 !important;
        }

        /* Estilos para a seção de ofertas fixa */
        .sticky-offer {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            z-index: 40;
        }
    </style>
</head>
<body class="bg-background text-primary font-sans">

<!-- Topo com Logo, WhatsApp, Endereço, Relógio e Modal -->
<div class="bg-card-bg px-4 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-0 text-sm shadow">
    <div class="flex items-center gap-4">
        <img src="images (4).jpeg" alt="Logo" class="w-20 h-20 rounded-full border-4 border-secondary shadow-lg transition-transform hover:scale-105">
        <span class="font-extrabold text-2xl md:text-3xl text-primary tracking-tight drop-shadow">{{ $restaurant->name }}</span>
    </div>
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <a href="https://wa.me/{{ $whatsappNumber }}" class="flex items-center gap-2 text-primary hover:text-secondary font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.89 11.89 0 0012 0C5.38 0 .03 5.35 0 11.97a11.93 11.93 0 001.64 6L0 24l6.21-1.62A11.91 11.91 0 0012 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22a9.97 9.97 0 01-5.15-1.42l-.37-.22-3.68.96.99-3.59-.24-.37A9.9 9.9 0 012 12C2.01 6.48 6.49 2 12 2c2.66 0 5.17 1.04 7.07 2.93A9.95 9.95 0 0122 12c0 5.52-4.48 10-10 10zm5.3-7.9c-.3-.15-1.77-.87-2.05-.96-.27-.1-.47-.15-.67.15s-.76.96-.93 1.15c-.17.2-.35.22-.65.07-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.78-1.68-2.08s-.02-.45.13-.6c.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5s.05-.37-.03-.52c-.08-.15-.67-1.6-.92-2.2s-.5-.5-.67-.5h-.57c-.17 0-.45.07-.68.37s-.9.87-.9 2.13c0 1.25.92 2.46 1.04 2.63.13.17 1.82 2.8 4.42 3.92.62.27 1.1.43 1.48.55.62.2 1.18.17 1.62.1.5-.07 1.54-.63 1.75-1.24.2-.6.2-1.13.14-1.24-.06-.12-.23-.18-.53-.33z"/></svg>
            {{ $whatsappNumber }}
        </a>
        <!-- Torne o endereço sempre visível no mobile -->
        <a
            href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restaurant->street . ', ' . $restaurant->number . ' - ' . $restaurant->neighborhood . ', ' . $restaurant->city . ' - ' . $restaurant->state) }}"
            target="_blank"
            class="inline text-base hover:text-secondary transition cursor-pointer"
        >📍 {{ $restaurant->street }}, {{ $restaurant->number }} - {{ $restaurant->neighborhood }}</a>
        <button
            onclick="document.getElementById('modalSobre').classList.remove('hidden')"
            class="bg-primary text-white px-4 py-2 rounded-lg shadow font-bold text-base hover:bg-secondary transition-all duration-200"
        >Sobre</button>
        <div class="flex items-center gap-2 mt-2 md:mt-0">
        <span id="status-abertura" class="flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-semibold {{ $isOpen ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' }} shadow-sm">
          <svg id="relogio-icone" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isOpen ? 'text-green-600' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke-width="2"/>
            <path d="M12 6v6l4 2" stroke-width="2"/>
          </svg>
          <span id="texto-abertura">{{ $isOpen ? 'Aberto agora' : 'Fechado agora' }}</span>
        </span>
            <button onclick="document.getElementById('modalHorario').classList.remove('hidden')" class="bg-secondary text-white px-5 py-2 rounded-lg shadow-lg font-bold text-base hover:bg-[#e45050] transition-all duration-200">
                ⏰ Ver horários
            </button>
        </div>
    </div>
</div>

<!-- Modal de Horários -->
<div id="modalHorario" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-2xl text-primary max-w-sm w-full">
        <h3 class="text-xl font-bold mb-4">Horário de Funcionamento</h3>
        <ul class="space-y-1 text-sm">
            @foreach($hours as $hour)
                <li class="{{ $hour->is_open ? '' : 'text-gray-400' }}">
                    <strong>{{ $hour->day_name }}:</strong>
                    @if($hour->is_open)
                        {{ date('H:i', strtotime($hour->opening_time)) }} às {{ date('H:i', strtotime($hour->closing_time)) }}
                    @else
                        Fechado
                    @endif
                </li>
            @endforeach
        </ul>
        <button onclick="document.getElementById('modalHorario').classList.add('hidden')" class="mt-4 bg-primary text-white px-4 py-2 rounded hover:bg-[#2e2727]">Fechar</button>
    </div>
</div>

<!-- Modal Sobre -->
<div id="modalSobre" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-xl shadow-2xl text-primary max-w-md w-full text-center relative">
        <button onclick="document.getElementById('modalSobre').classList.add('hidden')" class="absolute top-3 right-3 text-2xl text-secondary hover:text-primary">&times;</button>
        <img src="images (4).jpeg" alt="Logo" class="mx-auto w-28 h-28 rounded-full border-4 border-secondary shadow-lg mb-4">
        <h2 class="text-2xl font-extrabold mb-2">{{ $restaurant->name }}</h2>
        <p class="text-base text-gray-700 mb-2">Bem-vindo ao {{ $restaurant->name }}! Aqui você encontra delícias preparadas com carinho, ambiente familiar e atendimento especial. Venha experimentar nossos lanches, pizzas, porções e muito mais!</p>
        <p class="text-sm text-gray-500">{{ $restaurant->street }}, {{ $restaurant->number }} - {{ $restaurant->neighborhood }}, {{ $restaurant->city }} - {{ $restaurant->state }}</p>
    </div>
</div>

<!-- Modal Cardápio (dinâmico) -->
<div id="modalCardapio" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div id="modalCardapioContent" class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 relative text-primary">
        <button onclick="document.getElementById('modalCardapio').classList.add('hidden')" class="absolute top-3 right-3 text-2xl text-secondary hover:text-primary">&times;</button>
        <!-- Conteúdo dinâmico aqui -->
    </div>
</div>

<!-- Cabeçalho -->
<header class="bg-primary text-white p-8 text-left shadow-lg rounded-b-3xl md:rounded-b-[48px] mb-8">
    <h1 class="text-4xl font-extrabold tracking-tight mb-2">Cardápio Digital</h1>
    <p class="text-lg opacity-80">Delícias preparadas com carinho</p>
</header>

<main class="max-w-4xl mx-auto p-4 space-y-12">


    <!-- Navbar -->
    <nav class="bg-primary height text-white shadow sticky top-0 z-50 rounded-b-xl">
        <div class="max-w-6xl mx-auto px-2 sm:px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 font-bold text-xl">🍽️ Cardápio</div>
                <div class="hidden md:flex flex-wrap gap-2">
                    @foreach($categories as $category)
                        <a href="#{{ \Illuminate\Support\Str::slug($category->name) }}" class="hover:text-secondary transition px-2 py-1 rounded hover:bg-white/10">
                            {{ $category->icon ?? '🍽️' }} {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                <div class="md:hidden">
                    <button id="menu-button" class="hamburger focus:outline-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden px-2 pb-4 bg-primary rounded-b-xl flex flex-col gap-1">
            @foreach($categories as $category)
                <a href="#{{ \Illuminate\Support\Str::slug($category->name) }}" class="block py-2 hover:text-secondary">
                    {{ $category->icon ?? '🍽️' }} {{ $category->name }}
                </a>
            @endforeach
        </div>
    </nav>

    @foreach($categories as $category)
    <section id="{{ \Illuminate\Support\Str::slug($category->name) }}" class="book-section {{ $loop->first ? 'sticky top-20 z-40 sticky-offer' : '' }}">
        <h2 class="text-2xl font-extrabold mb-4 pb-2 border-b-2 border-[#ffd2d2]">
            @if($loop->first)
            <span class="inline-block animate-fire text-3xl" style="animation: fire 1s infinite;">
              🔥
            </span>
            {{ $category->offer_type ? ucfirst($category->offer_type) : ($category->is_offer ? 'Ofertas' : $category->name) }}
            @else
            {{ $category->icon ?? '🍽️' }}
            {{ $category->name }}
            @endif
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            @if(isset($items[$category->name]))
                @foreach($items[$category->name] as $item)
                <div class="{{ $loop->parent->first ? 'oferta-card rounded-xl' : 'bg-white rounded-xl' }} p-5 modern-shadow hover:scale-[1.03] transition-all duration-200">
                    <img src="{{ $item->image_url ?? 'comida.jpg' }}" alt="{{ $item->name }}" class="rounded-lg mb-3 w-full h-44 object-cover shadow">
                    <h3 class="text-lg font-bold mb-1">{{ $item->name }}</h3>
                    <p class="text-base text-gray-700">{{ $item->description }}</p>
                    @if($item->observation)
                    <p class="text-xs italic text-gray-500 mt-1">{{ $item->observation }}</p>
                    @endif
                    <span class="font-extrabold text-xl block mt-2 text-black">R$ {{ number_format($item->price, 2, ',', '.') }}</span>
                </div>
                @endforeach
            @else
                <div class="col-span-2 text-center py-4 text-gray-500">
                    Nenhum item disponível nesta categoria.
                </div>
            @endif
        </div>
    </section>
    @endforeach
</main>

<!-- Rodapé -->
<footer class="text-center p-6 text-sm text-primary mt-8">
    © 2025 Cardápio Digital. Todos os direitos reservados.
</footer>

<!-- Scripts -->
<script>
    // Hamburger menu animation
    const menuBtn = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
        menuBtn.classList.toggle('active');
        mobileMenu.classList.toggle('hidden');
    });

    // Animação na Seção de Ofertas
    window.addEventListener('DOMContentLoaded', () => {
        const ofertas = document.querySelector('#ofertas');
        if (ofertas) {
            ofertas.classList.add('animate-fadeInUp');
        }
    });

    // Status de abertura (baseado no horário do servidor)
    // Nota: O status já é definido diretamente no HTML pelo servidor
    // Não mostramos mais informações de tempo, apenas "Aberto agora" ou "Fechado agora"
    document.addEventListener('DOMContentLoaded', function() {
        const texto = document.getElementById('texto-abertura');
        const span = document.getElementById('status-abertura');
        const icone = document.getElementById('relogio-icone');

        // Usar os dados calculados pelo servidor
        const isOpen = {{ $isOpen ? 'true' : 'false' }};
        const status = '{{ $openingInfo['status'] }}';

        // Apenas ajustar a cor para status "opening_soon" (amarelo)
        if (status === 'opening_soon') {
            span.className = "flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700 border border-yellow-300 shadow-sm";
            icone.classList.remove('text-green-600', 'text-red-500');
            icone.classList.add('text-yellow-600');
            texto.textContent = "Fechado agora";
        }
    });

    // Modal Cardápio - abre ao clicar em qualquer card de comida/bebida/oferta
    function openCardModal(img, title, desc, obs, price) {
        const modal = document.getElementById('modalCardapio');
        const content = document.getElementById('modalCardapioContent');
        content.innerHTML = `
        <button onclick="document.getElementById('modalCardapio').classList.add('hidden')" class="absolute top-3 right-3 text-2xl text-secondary hover:text-primary">&times;</button>
        <img src="${img}" alt="${title}" class="w-full h-48 object-cover rounded-lg shadow mb-4">
        <h3 class="text-xl font-bold mb-2">${title}</h3>
        <p class="text-base text-gray-700 mb-2">${desc}</p>
        ${obs ? `<p class="text-xs italic text-gray-500 mb-2">${obs}</p>` : ''}
        <span class="font-extrabold text-xl block mt-2 text-black">${price}</span>
      `;
        modal.classList.remove('hidden');
    }

    // Adiciona evento a todos os cards do cardápio
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.oferta-card, .book-section .p-5').forEach(card => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function(e) {
                // Evita abrir modal ao clicar em botão/link dentro do card
                if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;
                const img = card.querySelector('img')?.src || '';
                const title = card.querySelector('h3')?.innerText || '';
                const desc = card.querySelector('p.text-base')?.innerText || '';
                const obs = card.querySelector('p.text-xs')?.innerText || '';
                const price = card.querySelector('span.font-extrabold')?.innerText || '';
                openCardModal(img, title, desc, obs, price);
            });
        });
    });
</script>
</body>
</html>
