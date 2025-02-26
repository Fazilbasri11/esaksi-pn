import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Jika menggunakan SCSS, pastikan untuk menambahkan path app.scss Anda
                additionalData: `@import "resources/sass/app.scss";`
            }
        }
    }
});

