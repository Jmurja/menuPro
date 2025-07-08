// Shopping Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart from localStorage or empty if not exists
    let cart = JSON.parse(localStorage.getItem('menuCart')) || [];

    // Update cart badge
    function updateCartBadge() {
        const cartBadge = document.getElementById('cart-count');
        if (cartBadge) {
            const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
            cartBadge.textContent = itemCount;

            // Show/hide badge based on count
            if (itemCount > 0) {
                cartBadge.classList.remove('hidden');
            } else {
                cartBadge.classList.add('hidden');
            }
        }
    }

    // Update cart items in the modal
    function updateCartItems() {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const finalizeButton = document.getElementById('finalize-order');

        if (cartItemsContainer) {
            // Clear current items
            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                if (emptyCartMessage) emptyCartMessage.classList.remove('hidden');
                if (finalizeButton) finalizeButton.classList.add('hidden');
                if (cartTotal) cartTotal.textContent = 'R$ 0,00';
                return;
            }

            if (emptyCartMessage) emptyCartMessage.classList.add('hidden');
            if (finalizeButton) finalizeButton.classList.remove('hidden');

            // Calculate total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            if (cartTotal) cartTotal.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;

            // Add items to cart
            cart.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between items-center py-2 border-b border-zinc-200 dark:border-zinc-700';
                itemElement.innerHTML = `
                    <div class="flex-1">
                        <h3 class="font-medium text-zinc-900 dark:text-white">${item.name}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            R$ ${item.price.toFixed(2).replace('.', ',')} x ${item.quantity}
                        </p>
                    </div>
                    <div class="flex items-center">
                        <button class="decrease-quantity px-2 py-1 text-sm bg-zinc-200 dark:bg-zinc-700 rounded-l-md"
                                data-index="${index}">-</button>
                        <span class="px-3 py-1 bg-zinc-100 dark:bg-zinc-800">${item.quantity}</span>
                        <button class="increase-quantity px-2 py-1 text-sm bg-zinc-200 dark:bg-zinc-700 rounded-r-md"
                                data-index="${index}">+</button>
                        <button class="remove-item ml-2 text-red-500 hover:text-red-700" data-index="${index}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemElement);
            });

            // Add event listeners for quantity buttons
            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    if (cart[index].quantity > 1) {
                        cart[index].quantity--;
                        saveCart();
                        updateCartItems();
                        updateCartBadge();
                    }
                });
            });

            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    cart[index].quantity++;
                    saveCart();
                    updateCartItems();
                    updateCartBadge();
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    cart.splice(index, 1);
                    saveCart();
                    updateCartItems();
                    updateCartBadge();
                });
            });
        }
    }

    // Save cart to localStorage
    function saveCart() {
        localStorage.setItem('menuCart', JSON.stringify(cart));
    }

    // Add item to cart
    function addToCart(id, name, price) {
        // Check if item already exists in cart
        const existingItemIndex = cart.findIndex(item => item.id === id);

        if (existingItemIndex !== -1) {
            // Increase quantity if item exists
            cart[existingItemIndex].quantity++;
        } else {
            // Add new item if it doesn't exist
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
        }

        saveCart();
        updateCartBadge();
        updateCartItems();

        // Show notification
        const notification = document.getElementById('cart-notification');
        if (notification) {
            notification.classList.remove('hidden');
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 2000);
        }
    }

    // Add event listeners to "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            addToCart(id, name, price);
        });
    });

    // Toggle cart modal
    const cartButton = document.getElementById('cart-button');
    const cartModal = document.getElementById('cart-modal');
    const closeCartButton = document.getElementById('close-cart');

    if (cartButton && cartModal) {
        cartButton.addEventListener('click', function() {
            cartModal.classList.remove('hidden');
            updateCartItems();
        });
    }

    if (closeCartButton && cartModal) {
        closeCartButton.addEventListener('click', function() {
            cartModal.classList.add('hidden');
        });
    }

    // Finalize order (send to WhatsApp)
    const finalizeButton = document.getElementById('finalize-order');
    if (finalizeButton) {
        finalizeButton.addEventListener('click', function() {
            const whatsappNumber = this.dataset.whatsapp;

            // Create message text
            let message = "Olá, gostaria de fazer o seguinte pedido:\n\n";

            cart.forEach(item => {
                message += `${item.quantity}x ${item.name} - R$ ${(item.price * item.quantity).toFixed(2).replace('.', ',')}\n`;
            });

            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            message += `\nTotal: R$ ${total.toFixed(2).replace('.', ',')}`;

            // Encode message for URL
            const encodedMessage = encodeURIComponent(message);

            // Open WhatsApp with the message
            window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
        });
    }

    // Initialize cart UI
    updateCartBadge();
});
