import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: 'localhost',
        port: 3000, // لو حابب تغير
        strictPort: true,
        proxy: {
            '^/api/.*': {
                target: 'http://localhost:8000',
                changeOrigin: true,
                secure: false,
                ws: true,
            },
        },
    },
});
