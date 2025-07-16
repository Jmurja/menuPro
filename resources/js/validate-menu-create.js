document.addEventListener('DOMContentLoaded', function () {

    const image = document.getElementById('image');

    function validateImage(input) {
        if (!input.files || input.files.length === 0) return '';
        const file = input.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowedTypes.includes(file.type)) {
            return 'O arquivo deve ser uma imagem válida (jpeg, png, gif, webp).';
        }

        if (file.size > maxSize) {
            return 'A imagem deve ter no máximo 2MB.';
        }

        return '';
    }


    const form = document.querySelector('#create-menu-item-form');
    if (!form) return;

    const name = document.getElementById('name');
    const price = document.getElementById('price');
    const category = document.getElementById('category_id');

    // Função para formatar valor como moeda brasileira
    function formatCurrency(value) {
        const numValue = parseFloat(value);
        if (isNaN(numValue)) return 'R$ 0,00';
        const cents = Math.round(numValue * 100);
        return 'R$ ' + (cents / 100).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Função para converter string formatada para número
    function currencyToNumber(formattedValue) {
        if (!formattedValue) return 0;
        const numericValue = formattedValue.replace(/[^\d]/g, '');
        return numericValue ? parseFloat(numericValue) / 100 : 0;
    }

    // Função para formatar o input de preço
    function formatPriceInput(e) {
        const input = e.target;
        const cursorPosition = input.selectionStart;
        const inputLength = input.value.length;
        let rawValue = input.value.replace(/[^\d]/g, '');
        let cents = parseInt(rawValue) || 0;
        let formattedValue = 'R$ ' + (cents / 100).toFixed(2).replace('.', ',');
        formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = formattedValue;
        const newCursorPosition = cursorPosition + (formattedValue.length - inputLength);
        input.setSelectionRange(newCursorPosition, newCursorPosition);
    }

    // Aplicar máscara de preço
    function applyPriceMask() {
        if (!price.value) {
            price.value = 'R$ 0,00';
        } else {
            price.value = formatCurrency(currencyToNumber(price.value));
        }

        price.removeEventListener('input', formatPriceInput);
        price.addEventListener('input', formatPriceInput);
    }

    applyPriceMask();

    // Funções de validação
    function validateName(input) {
        return input.value.trim() === '' ? 'O campo Nome é obrigatório.' : '';
    }

    function validatePrice(input) {
        const value = typeof input === 'object' && 'value' in input
            ? input.value
            : currencyToNumber(input.value);
        if (value === 0) return 'O campo Preço é obrigatório.';
        if (isNaN(value) || value < 0.01) return 'Informe um preço válido (mínimo R$ 0,01).';
        return '';
    }


    function validateCategory(input) {
        return !input.value ? 'Selecione uma categoria válida.' : '';
    }

    // Mostrar erro abaixo do campo
    function showError(input, message) {
        clearError(input);
        if (message) {
            input.classList.add('border-red-500', 'ring-red-500');
            const error = document.createElement('p');
            error.className = 'text-red-500 text-sm mt-1';
            error.textContent = message;
            input.insertAdjacentElement('afterend', error);
        }
    }

    // Remover erro
    function clearError(input) {
        input.classList.remove('border-red-500', 'ring-red-500');
        const next = input.nextElementSibling;
        if (next && next.classList.contains('text-red-500')) {
            next.remove();
        }
    }

    // Campos com validação
    const fields = [
        { el: name, validate: validateName },
        { el: price, validate: validatePrice },
        { el: category, validate: validateCategory },
        { el: image, validate: validateImage }
    ];



    // Validação em tempo real (input/blur)
    fields.forEach(field => {
        if (!field.el) return;

        field.el.addEventListener('blur', () => {
            const error = field.el.id === 'price'
                ? validatePrice({ value: currencyToNumber(price.value) })
                : field.validate(field.el);
            showError(field.el, error);
        });

        field.el.addEventListener('input', () => {
            clearError(field.el);
        });
    });

    // Submissão do formulário
    form.addEventListener('submit', function (e) {
        let isValid = true;
        const rawValue = currencyToNumber(price.value);
        const formattedPrice = price.value;

        fields.forEach(field => {
            if (!field.el) return;
            const error = field.el.id === 'price'
                ? validatePrice({ value: rawValue })
                : field.validate(field.el);
            showError(field.el, error);
            if (error) isValid = false;
        });

        if (!isValid) {
            e.preventDefault();
            price.value = formattedPrice; // restaura formatação se inválido
        } else {
            price.value = rawValue; // envia valor numérico
        }
    });
});
