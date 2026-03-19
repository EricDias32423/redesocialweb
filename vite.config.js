import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/css/login.css',
                'resources/css/register.css',
                'resources/css/loginong.css',
                'resources/css/registerong.css'
            ],
            refresh: true,
        }),
    ],
});
