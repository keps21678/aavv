import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: ['resources/views/**/*'],
            detectTls: true, // Detectar automáticamente el certificado TLS
            server: {
                https: true, // Habilitar HTTPS
                host: 'prueba01.test', // Tu dominio local
                port: 3000, // Puerto para el servidor de desarrollo
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            'Swal': 'sweetalert2',
            'DataTable': 'datatables.net',
        },
    },     
    server: {
        cors: true,
        https: true, // Habilitar HTTPS
        host: 'prueba01.test', // Tu dominio local
    },
});