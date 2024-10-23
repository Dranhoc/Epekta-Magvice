import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
  plugins: [
      viteStaticCopy({
          targets: [
              { src: 'node_modules/tarteaucitronjs/lang', dest: '../vendor/tarteaucitron' },
              { src: 'node_modules/tarteaucitronjs/tarteaucitron.min.js', dest: '../vendor/tarteaucitron' },
              { src: 'node_modules/tarteaucitronjs/tarteaucitron.services.min.js', dest: '../vendor/tarteaucitron' }
          ]
      }),
    laravel({
      input: [
        'resources/scss/frontoffice/index.scss',
        'resources/js/frontoffice/index.ts',
        'resources/js/frontoffice/tarteaucitron.js',
        'resources/js/backoffice/index.ts',
        'resources/scss/backoffice/index.scss',
        'resources/scss/frontoffice/index.scss',
      ],
      refresh: true,
    }),
    vue(),
    svgLoader()
  ],
  define: {
    global: {},
  },
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
      '@icons': '/resources/svg',
      '@': '/resources/js'
    },
  },
});
