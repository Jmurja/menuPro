document.addEventListener('DOMContentLoaded', function () {
    const cepInputs = document.querySelectorAll('input[name="zip_code"]');

    cepInputs.forEach(input => {
        // Aplica máscara dinâmica no input
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '').slice(0, 8);

            if (value.length > 5) {
                this.value = value.slice(0, 5) + '-' + value.slice(5);
            } else {
                this.value = value;
            }
        });

        // Dispara requisição ao ViaCEP ao sair do campo
        input.addEventListener('blur', function () {
            const cep = this.value.replace(/\D/g, '');

            if (cep.length !== 8) return;

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                        return;
                    }

                    const form = this.closest('form');
                    if (!form) return;

                    const prefix = this.id.replace('zip_code-', '');

                    const field = (name) => {
                        return form.querySelector(`#${name}-${prefix}`) || form.querySelector(`#${name}`);
                    };

                    if (field('street')) field('street').value = data.logradouro || '';
                    if (field('neighborhood')) field('neighborhood').value = data.bairro || '';
                    if (field('city')) field('city').value = data.localidade || '';
                    if (field('state')) field('state').value = data.uf || '';
                })
                .catch(() => {
                    alert('Erro ao consultar o CEP.');
                });
        });
    });
});
