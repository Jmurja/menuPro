document.addEventListener('DOMContentLoaded', () => {
    const mesasEl = document.getElementById('mesas');

    const renderMesas = (data) => {
        mesasEl.innerHTML = '';

        if (data.tables.length === 0) {
            mesasEl.innerHTML = `
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Nenhuma mesa com pedidos</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 max-w-sm">Quando houver mesas com pedidos em aberto, elas aparecerão aqui para fechamento de conta.</p>
                </div>
            `;
            return;
        }

        data.tables.forEach(table => {
            const mesaDiv = document.createElement('div');
            mesaDiv.className = 'border border-zinc-200 dark:border-zinc-700 rounded-lg p-5 bg-white dark:bg-zinc-800 shadow-sm hover:shadow-md transition-shadow duration-200';

            const header = `
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-700">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Mesa: ${table.table}
                        </h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                            ${table.orders.length} pedido(s) em aberto
                        </p>
                    </div>
                    <form method="POST" action="/caixa/fechar-conta">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <input type="hidden" name="table" value="${table.table}">
                         <button
                            type="button"
                            data-close-table="${table.table}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Fechar Conta
                        </button>
                    </form>
                </div>
            `;

            const pedidos = table.orders.map(order => {
                const items = order.items.map(item =>
                    `<li class="py-1 border-b border-zinc-100 dark:border-zinc-700 last:border-0 flex justify-between">
                        <span class="font-medium">${item.name}</span>
                        <span class="text-zinc-500 dark:text-zinc-400">x${item.quantity}</span>
                    </li>`
                ).join('');

                return `
                    <div class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4 bg-white dark:bg-zinc-800/50">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Pedido #${order.id}
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">${order.created_at}</p>
                        </div>
                        <ul class="text-sm text-zinc-700 dark:text-zinc-300 divide-y divide-zinc-100 dark:divide-zinc-700">${items}</ul>
                    </div>
                `;
            }).join('');

            mesaDiv.innerHTML = header + `<div class="space-y-4">${pedidos}</div>`;
            mesasEl.appendChild(mesaDiv);
        });
    };

    const fetchMesas = () => {
        fetch('/caixa/pedidos-abertos', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(renderMesas)
            .catch(err => console.error('Erro ao buscar pedidos:', err));
    };

    document.addEventListener('click', (e) => {
        if (e.target.matches('[data-close-table]')) {
            e.preventDefault();
            const table = e.target.dataset.closeTable;

            fetch(`/caixa/resumo-da-conta?table=${table}`)
                .then(res => res.json())
                .then(data => {
                    showModal(table, data.items, data.total);
                })
                .catch(err => alert('Erro ao buscar resumo.'));
        }
    });

    function showModal(table, items, total) {
        const drawer = document.getElementById('drawer');
        const content = document.getElementById('drawer-content');
        const totalEl = document.getElementById('drawer-total');
        const tableInput = document.getElementById('drawer-table');
        const title = document.getElementById('drawer-title');

        title.innerText = `Mesa ${table} - Resumo`;
        content.innerHTML = '';

        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'flex justify-between border-b border-zinc-200 py-3 dark:border-zinc-700 last:border-0';
            div.innerHTML = `
                <div class="flex items-start">
                    <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-2 mt-0.5">
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">${item.quantity}</span>
                    </div>
                    <span class="font-medium">${item.name}</span>
                </div>
                <span class="font-medium text-green-600 dark:text-green-400">R$ ${(item.total).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</span>
            `;
            content.appendChild(div);
        });

        totalEl.innerText = total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        tableInput.value = table;

        drawer.classList.remove('translate-x-full');
    }

    const closeBtn = document.getElementById('drawer-cancel');
    const closeBtnAlt = document.getElementById('drawer-cancel-alt');

    const closeDrawer = () => {
        document.getElementById('drawer').classList.add('translate-x-full');
    };

    closeBtn.addEventListener('click', closeDrawer);
    closeBtnAlt.addEventListener('click', closeDrawer);

    setInterval(fetchMesas, 10000);
        fetchMesas();
});
