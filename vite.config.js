import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import autoprefixer from 'autoprefixer';
import tailwindcss from '@tailwindcss/postcss';

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
  ],
  resolve: {
      alias: {
          '@': path.resolve(__dirname, './resources/js'),
          vue: 'vue/dist/vue.esm-bundler.js',
      },
  },
  css: {
      postcss: {
          plugins: [tailwindcss, autoprefixer],
      },
  },
  build: {
      outDir: "public/build",
  },
  server: {
      proxy: {
          '/api': {
              target: 'http://localhost:8000/api',
              changeOrigin: true,
              secure: false,
          },
      },
  },
});