import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/js/main.js',
            ],
            refresh: ['resources/**'],
        }),
        vue(),
    ],
});
