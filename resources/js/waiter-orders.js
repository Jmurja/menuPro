document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const newOrderForm = document.getElementById('new-order-form');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    const toastSuccess = document.getElementById('toast-success');

    // Cart state
    let cartItems = [];
    let cartTotal = 0;

    // Add item to cart
    addToCartBtn.addEventListener('click', function() {
        const itemId = document.getElementById('item_id').value;
        const itemName = document.getElementById('item_id').options[document.getElementById('item_id').selectedIndex].text;
        const quantity = parseInt(document.getElementById('quantity').value);
        const notes = document.getElementById('notes').value;

        if (!itemId) {
            alert('Por favor, selecione um item.');
            return;
        }

        if (quantity < 1) {
            alert('A quantidade deve ser pelo menos 1.');
            return;
        }

        // Extract price from the option text (format: "Item Name - R$ 10,00")
        const priceMatch = itemName.match(/R\$ ([\d,]+)/);
        if (!priceMatch) {
            alert('Erro ao obter o preço do item.');
            return;
        }

        const price = parseFloat(priceMatch[1].replace(',', '.'));
        const itemTotal = price * quantity;

        // Add to cart
        cartItems.push({
            id: itemId,
            name: itemName.split(' - R$')[0],
            price: price,
            quantity: quantity,
            notes: notes,
            total: itemTotal
        });

        // Update cart total
        cartTotal += itemTotal;

        // Update UI
        updateCartUI();

        // Reset form fields
        document.getElementById('item_id').value = '';
        document.getElementById('quantity').value = '1';
        document.getElementById('notes').value = '';
    });

    // Update cart UI
    function updateCartUI() {
        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="text-center text-zinc-500 dark:text-zinc-400 py-4">
                    Nenhum item adicionado ao pedido
                </div>
            `;
            cartTotalElement.textContent = '0,00';
            return;
        }

        cartItemsContainer.innerHTML = '';

        cartItems.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between items-start p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg';
            itemElement.innerHTML = `
                <div class="flex items-start">
                    <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-2 mt-0.5">
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">${item.quantity}</span>
                    </div>
                    <div>
                        <span class="font-medium">${item.name}</span>
                        ${item.notes ? `<p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">${item.notes}</p>` : ''}
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="font-medium text-green-600 dark:text-green-400 mr-2">R$ ${item.total.toFixed(2).replace('.', ',')}</span>
                    <button type="button" class="text-red-500 hover:text-red-700 dark:hover:text-red-400" data-remove-item="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            cartItemsContainer.appendChild(itemElement);
        });

        cartTotalElement.textContent = cartTotal.toFixed(2).replace('.', ',');

        // Add event listeners to remove buttons
        document.querySelectorAll('[data-remove-item]').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-remove-item'));
                removeCartItem(index);
            });
        });
    }

    // Remove item from cart
    function removeCartItem(index) {
        if (index >= 0 && index < cartItems.length) {
            const item = cartItems[index];
            cartTotal -= item.total;
            cartItems.splice(index, 1);
            updateCartUI();
        }
    }

    // Submit order
    newOrderForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const tableNumber = document.getElementById('table_number').value;

        if (!tableNumber) {
            alert('Por favor, informe o número da mesa.');
            return;
        }

        if (cartItems.length === 0) {
            alert('Por favor, adicione pelo menos um item ao pedido.');
            return;
        }

        // Prepare data for submission
        const orderData = {
            table: tableNumber,
            items: cartItems,
            _token: document.querySelector('meta[name="csrf-token"]').content
        };

        // Submit order via AJAX
        fetch('/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(orderData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao enviar pedido');
            }
            return response.json();
        })
        .then(data => {
            // Show success toast
            toastSuccess.classList.remove('hidden');
            setTimeout(() => {
                toastSuccess.classList.add('hidden');
            }, 3000);

            // Reset form and cart
            document.getElementById('table_number').value = '';
            cartItems = [];
            cartTotal = 0;
            updateCartUI();

            // Refresh active orders (if implemented)
            // fetchActiveOrders();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao enviar pedido. Por favor, tente novamente.');
        });
    });

    // Initialize cart UI
    updateCartUI();

    // Close toast when clicking the close button
    document.querySelector('[data-dismiss-target="#toast-success"]').addEventListener('click', function() {
        toastSuccess.classList.add('hidden');
    });

    // Function to fetch active orders (can be implemented if needed)
    function fetchActiveOrders() {
        // Fetch active orders from the server
        // This would be implemented if real-time updates are needed
    }
});
