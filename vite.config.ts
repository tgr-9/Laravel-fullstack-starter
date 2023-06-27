import { resolve } from 'node:path'
import i18n from '@intlify/unplugin-vue-i18n/vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import autoImport from 'unplugin-auto-import/vite'
import components from 'unplugin-vue-components/vite'
import { NaiveUiResolver } from 'unplugin-vue-components/resolvers'
import windicss from 'vite-plugin-windicss'
import { VitePWA as pwa } from 'vite-plugin-pwa'
import { defineConfig, loadEnv } from 'vite'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, '.', ['APP', 'VITE'])

  const rootdir = 'resources/client'

  return {
    resolve: {
      alias: {
        '~/': `${resolve(__dirname, rootdir)}/`,
        'ziggy/': `${resolve('vendor/tightenco/ziggy/src/js')}/`,
      },
    },

    define: {
      'import.meta.env.APP_NAME': JSON.stringify(env.APP_NAME),
      'import.meta.env.APP_LOCALE': JSON.stringify(env.APP_LOCALE),
      'import.meta.env.APP_URL': JSON.stringify(env.APP_URL),
      'import.meta.env.APP_ENV': JSON.stringify(env.APP_ENV),
    },

    plugins: [
      /**
       * @see https://laravel.com/docs/vite
       */
      laravel({
        input: [
          `${rootdir}/app.ts`,
        ],
        // refresh: true,
      }),

      vue({
        include: [/\.vue$/],
        template: {
          // transformAssetUrl,
        },
      }),

      /**
       * @see https://windicss.org/integrations/vite.html
       */
      windicss(),

      /**
       * @see https://github.com/antfu/unplugin-auto-import
       */
      autoImport({
        dts: `${rootdir}/auto-imports.d.ts`,
        dirs: [
          `${rootdir}/composables`,
          `${rootdir}/store`,
        ],
        imports: [
          '@vueuse/core',
          {
            'naive-ui': [],
          },
          'vue-i18n',
          'vue/macros',
          'vue',
        ],
        vueTemplate: true,
      }),

      /**
       * @see https://github.com/antfu/unplugin-vue-components
       */
      components({
        dts: `${rootdir}/components.d.ts`,
        dirs: [
          `${rootdir}/components`,
          `${rootdir}/layouts`,
        ],
        resolvers: [
          NaiveUiResolver(),
        ],
      }),

      /**
       * @see https://github.com/intlify/bundle-tools/tree/main/packages/vite-plugin-vue-i18n
       */
      i18n({
        runtimeOnly: true,
        compositionOnly: true,
        include: [resolve(__dirname, './resources/lang/**')],
      }),

      /**
       * @see https://vite-pwa-org.netlify.app/guide
       */
      pwa({
        injectRegister: 'script',
        registerType: 'autoUpdate',
        devOptions: {
          enabled: (mode !== 'production' && !!env.APP_DEBUG),
        },
        strategies: 'generateSW',
        workbox: {
          globPatterns: ['**/*.{ts,js,css,html,ico,png,svg}'],
          navigateFallback: null,
        },
        manifest: {
          id: '/',
          name: env.APP_NAME,
          short_name: env.APP_NAME,
          start_url: '/',
          display: 'fullscreen',
          background_color: '#ffffff',
          lang: env.APP_LOCALE || 'id',
          scope: '/',
          theme_color: '#ffffff',
          orientation: 'any',
          icons: [
            {
              src: '/favicon.ico',
              sizes: '48x48',
            },
            {
              src: '/assets/favicon.svg',
              sizes: '512x512',
              type: 'image/svg+xml',
            },
            {
              src: '/assets/icon-192x192.png',
              sizes: '192x192',
              type: 'image/png',
            },
            {
              src: '/assets/icon-512x512.png',
              sizes: '512x512',
              type: 'image/png',
            },
            {
              src: '/assets/icon-512x512.png',
              sizes: '512x512',
              type: 'image/png',
              purpose: 'maskable',
            },
          ],
        },
      }),
    ],
  }
})
