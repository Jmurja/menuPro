let cart = [];

function addToCart(id, name, price) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }

    renderCart();
}

function renderCart() {
    const cartEl = document.getElementById('cart');
    const list = document.getElementById('cart-items');
    const totalEl = document.getElementById('cart-total');

    list.innerHTML = '';
    let total = 0;

    if (cart.length > 0) {
        cartEl.classList.remove('hidden');
    } else {
        cartEl.classList.add('hidden');
    }

    cart.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="flex justify-between items-center">
                <span>${item.name} x${item.quantity}</span>
                <div class="flex gap-1">
                    <button onclick="changeQuantity(${index}, -1)" class="px-2 bg-zinc-200 dark:bg-zinc-700 rounded">-</button>
                    <button onclick="changeQuantity(${index}, 1)" class="px-2 bg-zinc-200 dark:bg-zinc-700 rounded">+</button>
                    <button onclick="removeItem(${index})" class="px-2 bg-red-500 text-white rounded">x</button>
                </div>
            </div>
        `;
        list.appendChild(li);
        total += item.price * item.quantity;
    });

    totalEl.innerText = total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
}

function changeQuantity(index, delta) {
    cart[index].quantity += delta;
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function submitOrder() {
    const table = document.getElementById('table').value;
    if (!table) {
        alert('Informe a mesa!');
        return;
    }

    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            table: table,
            items: cart,
        }),
    })
        .then(response => {
            if (!response.ok) throw new Error('Erro ao enviar pedido');
            return response.json();
        })
        .then(data => {
            alert(data.message);
            cart = [];
            renderCart();
            document.getElementById('table').value = '';
        })
        .catch(error => {
            console.error(error);
            alert('Erro ao enviar pedido');
        });
}

// Inicialização dos botões ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-add-to-cart]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            addToCart(parseInt(id), name, price);
        });
    });
});

// Expõe funções no escopo global (caso queira chamar via `onclick`)
window.addToCart = addToCart;
window.renderCart = renderCart;
window.changeQuantity = changeQuantity;
window.removeItem = removeItem;
window.submitOrder = submitOrder;
