import tailwindcss from "@tailwindcss/vite";
import laravel from 'laravel-vite-plugin';
import {
    defineConfig
} from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/validate-menu-create.js',
                'resources/js/cart.js',
                'resources/js/darkMode.js',
                'resources/js/format-phone.js',
                'resources/js/viacep.js',
                'resources/js/cpf-mask.js',
                'resources/js/cnpj-mask.js',
                'resources/js/cashier.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
