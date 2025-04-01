import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: ['resources/views/**/*'],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        https: true, // Habilitar HTTPS
        host: 'prueba01.test', // Tu dominio local
    },
});