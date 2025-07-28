document.addEventListener('DOMContentLoaded', () => {
    const mesasEl = document.getElementById('mesas');

    const renderMesas = (data) => {
        mesasEl.innerHTML = '';

        if (data.tables.length === 0) {
            mesasEl.innerHTML = '<p class="text-zinc-500 dark:text-zinc-400">Nenhuma mesa com pedidos em aberto.</p>';
            return;
        }

        data.tables.forEach(table => {
            const mesaDiv = document.createElement('div');
            mesaDiv.className = 'border border-zinc-300 dark:border-zinc-700 rounded-lg p-4 bg-white dark:bg-zinc-800';

            const header = `
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Mesa: ${table.table}</h2>
                    <form method="POST" action="/caixa/fechar-conta">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <input type="hidden" name="table" value="${table.table}">
                         <button
                            type="button"
                            data-close-table="${table.table}"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Fechar Conta
                        </button>

                    </form>
                </div>
            `;

            const pedidos = table.orders.map(order => {
                const items = order.items.map(item =>
                    `<li>${item.name} x${item.quantity}</li>`
                ).join('');

                return `
                    <div class="border border-zinc-200 dark:border-zinc-600 rounded p-3">
                        <p class="text-sm text-zinc-500 dark:text-zinc-300">Pedido #${order.id} - ${order.created_at}</p>
                        <ul class="list-disc pl-5 text-sm mt-2 text-zinc-700 dark:text-zinc-300">${items}</ul>
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
            div.className = 'flex justify-between border-b border-zinc-200 py-2 dark:border-zinc-700';
            div.innerHTML = `
                <span>${item.name} x${item.quantity}</span>
                <span>R$ ${(item.total).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</span>
            `;
            content.appendChild(div);
        });

        totalEl.innerText = total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        tableInput.value = table;

        drawer.classList.remove('translate-x-full');
    }

    const closeBtn = document.getElementById('drawer-cancel');
    closeBtn.addEventListener('click', () => {
        document.getElementById('drawer').classList.add('translate-x-full');
    });

    setInterval(fetchMesas, 10000);
        fetchMesas();
});
