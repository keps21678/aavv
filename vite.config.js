import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: ['resources/views/**/*'],
            detectTls: true, // Detectar automáticamente el certificado TLS 
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
        https: true, // Habilitar HTTPS
        host: 'prueba01.test', // Tu dominio local
        port: 3000, // Puerto para el servidor de desarrollo
        certificate: {
            key: 'D:/xampp/apache/conf/ssl.key/prueba01.test.key', // Ruta al archivo de clave privada
            cert: 'D:/xampp/apache/conf/ssl.crt/prueba01.test.crt', // Ruta al archivo de certificado
        },
                   
    },
});