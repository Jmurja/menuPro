<x-layouts.app :title="__('Caixa')">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6">Controle de Mesas</h1>

        <div id="mesas" class="space-y-8"></div>

    </div>

    <div id="drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="p-6 flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <h2 id="drawer-title" class="text-xl font-semibold text-zinc-900 dark:text-white">Resumo da Conta</h2>
            </div>

            <div id="drawer-content" class="flex-1 overflow-y-auto text-sm text-zinc-800 dark:text-zinc-200"></div>

            <div class="mt-4">
                <p class="font-semibold text-lg text-green-700 dark:text-green-400">Total: R$ <span id="drawer-total">0,00</span></p>
            </div>

            <form id="drawer-form" method="POST" action="/caixa/fechar-conta" class="mt-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="table" id="drawer-table">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Confirmar Fechamento</button>
                <button type="button" id="drawer-cancel" class="w-full mt-2 bg-zinc-200 text-zinc-800 px-4 py-2 rounded hover:bg-zinc-300 dark:bg-zinc-700 dark:text-white dark:hover:bg-zinc-600">
                    Cancelar
                </button>
            </form>
        </div>
    </div>

</x-layouts.app>
@vite('resources/js/cashier.js')
