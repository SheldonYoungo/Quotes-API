import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
              transformAssetUrls: {
                base: null,
                includeAbsolute: false,
              },
            },
          }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
          vue: 'vue/dist/vue.esm-bundler.js', // Asegúrate de usar esta versión
        },
    },
    server: {
      proxy: {
        '/api': {
          target: 'http://localhost:8000/api', // URL de tu servidor Laravel
          changeOrigin: true,
          secure: false,
        },
      },
    },
});
