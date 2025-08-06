<x-layouts.app :title="__('Caixa')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Controle de Mesas</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Gerencie os pedidos e fechamento de contas</p>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Mesas com Pedidos Abertos</h2>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                    <span class="inline-flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Atualização automática
                    </span>
                </div>
            </div>
            <div id="mesas" class="space-y-6"></div>
        </div>
    </div>

    <!-- Drawer para fechamento de conta -->
    <div id="drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl transform translate-x-full transition-transform duration-300 z-50 border-l border-zinc-200 dark:border-zinc-700">
        <div class="p-6 flex flex-col h-full">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 id="drawer-title" class="text-xl font-semibold text-zinc-900 dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Resumo da Conta
                </h2>
                <button type="button" id="drawer-cancel" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="drawer-content" class="flex-1 overflow-y-auto text-sm text-zinc-800 dark:text-zinc-200 mb-4"></div>

            <div class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <p class="font-semibold text-lg text-green-700 dark:text-green-400 flex items-center justify-between">
                    <span>Total:</span>
                    <span>R$ <span id="drawer-total" class="text-xl">0,00</span></span>
                </p>
            </div>

            <form id="drawer-form" method="POST" action="/caixa/fechar-conta" class="mt-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="table" id="drawer-table">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Confirmar Fechamento
                </button>
                <button type="button" id="drawer-cancel-alt" class="w-full mt-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 px-4 py-3 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-200">
                    Voltar
                </button>
            </form>
        </div>
    </div>

</x-layouts.app>
@vite('resources/js/cashier.js')
