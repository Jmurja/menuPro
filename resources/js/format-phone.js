document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('.phone-input');

    function formatPhone(value) {
        value = value.replace(/\D/g, ''); // Remove não numéricos

        if (value.length > 11) {
            value = value.slice(0, 11);
        }

        if (value.length >= 11) {
            return value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        } else if (value.length >= 10) {
            return value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
        } else if (value.length >= 6) {
            return value.replace(/^(\d{2})(\d{4})/, '($1) $2-');
        } else if (value.length >= 3) {
            return value.replace(/^(\d{2})(\d{1,4})/, '($1) $2');
        } else if (value.length > 0) {
            return value.replace(/^(\d{1,2})/, '($1');
        }

        return value;
    }

    phoneInputs.forEach(input => {
        // Formata imediatamente ao carregar (inclusive ao abrir modal)
        input.value = formatPhone(input.value);

        // Reaplica ao digitar
        input.addEventListener('input', function (e) {
            e.target.value = formatPhone(e.target.value);
        });

        // Impede letras
        input.addEventListener('keypress', function (e) {
            const charCode = e.charCode || e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });
    });
});
