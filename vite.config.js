import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 5175,
    hmr: {
      host: 'localhost',
    },
  },
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
      'ziggy-js': path.resolve(__dirname, 'vendor/tightenco/ziggy/dist/index.js'),
      '@': path.resolve(__dirname, './resources/js'),
    },
  },
  optimizeDeps: {
    include: ['chart.js'],
  },
});