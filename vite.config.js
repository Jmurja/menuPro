import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

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
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
