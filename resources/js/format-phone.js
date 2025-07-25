document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('.phone-input');

    phoneInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número

            // Limita a 11 dígitos (formato com DDD + celular)
            if (value.length > 11) {
                value = value.slice(0, 11);
            }

            // Aplica a máscara: (99) 99999-9999 ou (99) 9999-9999
            if (value.length >= 11) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (value.length >= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
            } else if (value.length >= 6) {
                value = value.replace(/^(\d{2})(\d{4})/, '($1) $2-');
            } else if (value.length >= 3) {
                value = value.replace(/^(\d{2})(\d{1,4})/, '($1) $2');
            } else if (value.length > 0) {
                value = value.replace(/^(\d{1,2})/, '($1');
            }

            e.target.value = value;
        });

        // Impede digitar letras manualmente (redundante com o replace acima, mas bom UX)
        input.addEventListener('keypress', function (e) {
            const charCode = e.charCode || e.keyCode;
            // Permite apenas números
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });
    });
});
