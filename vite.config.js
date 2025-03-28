import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import autoprefixer from 'autoprefixer';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
      laravel({
          input: ['/src/resources/css/app.css', '/src/resources/js/app.js'],
          refresh: true,
      }),
      tailwindcss(),
  ],
  resolve: {
      alias: {
          '@': path.resolve(__dirname, 'src/resources/js'),
          vue: 'vue/dist/vue.esm-bundler.js',
      },
  },
  css: {
      postcss: {
          plugins: [tailwindcss, autoprefixer],
      },
  },
  build: {
      outDir: path.resolve(__dirname, 'public/build'),
      rollupOptions: {
        input: path.resolve(__dirname, 'src/resources/js/app.js'),
      },
  },
//   server: {
//     proxy: {
//           '/api': {
//               target: 'http://localhost:8000/api',
//               changeOrigin: true,
//               secure: false,
//           },
//       },
//   },
});