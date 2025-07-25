document.addEventListener('DOMContentLoaded', function () {
    const formatCNPJ = (value) => {
        value = value.replace(/\D/g, '');
        if (value.length !== 14) return value;
        return value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
    };

    document.querySelectorAll('.cnpj-mask').forEach(input => {
        // Formata automaticamente valor preenchido ao abrir modal
        if (input.value && input.value.length === 14) {
            input.value = formatCNPJ(input.value);
        }

        // Aplica a máscara conforme digita
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d)/, "$1.$2");
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
            value = value.replace(/(\d{4})(\d)/, "$1-$2");
            this.value = value.slice(0, 18);
        });
    });
});
