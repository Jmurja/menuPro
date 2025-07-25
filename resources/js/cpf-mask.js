document.addEventListener('DOMContentLoaded', function () {
    const formatCPF = (cpf) => {
        cpf = cpf.replace(/\D/g, '');
        if (cpf.length !== 11) return cpf;
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    };

    // Aplica a máscara enquanto digita
    document.querySelectorAll('.cpf-mask').forEach(input => {
        // Formata valor atual ao carregar (caso já tenha valor no modal de edição)
        if (input.value && input.value.length === 11) {
            input.value = formatCPF(input.value);
        }

        // Aplica máscara conforme digita
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.value = value.slice(0, 14);
        });
    });
});
