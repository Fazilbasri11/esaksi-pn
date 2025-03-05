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
    server: {
        strictPort: true,
        https: true,  // **Pastikan Vite pakai HTTPS**
        hmr: {
            host: 'esaksi-pn-calang.web.id'
        }
    },
    base: process.env.APP_URL + "/build/",
    css: {
        preprocessorOptions: {
            scss: {
                // Jika menggunakan SCSS, pastikan untuk menambahkan path app.scss Anda
                additionalData: `@import "resources/sass/app.scss";`
            }
        }
    }
});

