import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin/app.css',
                'resources/css/front/app.css',
                'resources/js/admin/app.js',
                'resources/js/front/app.js'
            ],
            refresh: true,
        }),
    ],
});
