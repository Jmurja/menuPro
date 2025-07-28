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
                        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Fechar Conta</button>
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

    setInterval(fetchMesas, 10000);
    fetchMesas(); // carrega imediatamente ao entrar
});
