import { resolve } from 'node:path'
import { readFileSync } from 'node:fs'
import { sentryVitePlugin } from '@sentry/vite-plugin'
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
  const env = loadEnv(mode, '.', ['APP', 'SENTRY', 'VITE'])
  const rootdir = 'resources/client'

  function httpsCert() {
    if (!env.APP_URL.startsWith('https://'))
      return false

    try {
      return {
        cert: readFileSync(resolve(__dirname, 'storage/local-cert.pem')),
        key: readFileSync(resolve(__dirname, 'storage/local-key.pem')),
      }
    }
    catch {
      return false
    }
  }

  return {
    resolve: {
      alias: {
        '~/': `${resolve(__dirname, rootdir)}/`,
      },
    },

    optimizeDeps: {
      include: [],
      exclude: [
        'vue-demi',
      ],
    },

    build: {
      sourcemap: mode === 'development' || 'SENTRY_AUTH_TOKEN' in env,
      reportCompressedSize: false,
      chunkSizeWarningLimit: 2000,
      rollupOptions: {
        output: {
          /**
           * @see https://rollupjs.org/configuration-options/#output-manualchunks
           */
          manualChunks: (id) => {
            if (id.includes('node_modules'))
              return 'vendor'
          },
        },
      },
    },

    define: {
      'import.meta.env.APP_NAME': JSON.stringify(env.APP_NAME),
      'import.meta.env.APP_LOCALE': JSON.stringify(env.APP_LOCALE),
      'import.meta.env.APP_URL': JSON.stringify(env.APP_URL),
      'import.meta.env.APP_ENV': JSON.stringify(env.APP_ENV),
      'import.meta.env.SENTRY_DSN': JSON.stringify(env.SENTRY_DSN),
      'import.meta.env.SENTRY_PROFILING_ENABLE': Boolean(env.SENTRY_PROFILING_ENABLE ?? 0),
    },

    server: {
      host: '127.0.0.1',
      https: httpsCert(),
    },

    plugins: [
      /**
       * @see https://laravel.com/docs/vite
       */
      laravel({
        input: [
          `${rootdir}/app.ts`,
        ],
        // valetTls: env.APP_ENV === 'local' && env.APP_URL.startsWith('https://'),
        // refresh: true,
      }),

      vue(),

      /**
       * @see https://www.npmjs.com/package/@sentry/vite-plugin
       */
      sentryVitePlugin({
        org: env.SENTRY_ORG,
        project: env.SENTRY_PROJECT,
        authToken: env.SENTRY_AUTH_TOKEN,
        telemetry: !['local', 'testing'].includes(env.APP_ENV),
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
          `${rootdir}/utils`,
          // `${rootdir}/store`,
        ],
        imports: [
          '@vueuse/core',
          { 'naive-ui': [] },
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
          // `${rootdir}/layouts`,
        ],
        directoryAsNamespace: true,
        include: [/\.vue$/, /\.vue\?vue/],
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
        devOptions: {
          enabled: (mode !== 'production' && !!env.APP_DEBUG),
        },
        filename: 'sw.ts',
        srcDir: rootdir,
        registerType: 'autoUpdate',
        strategies: 'injectManifest',
        workbox: {
          mode,
          globPatterns: ['**/*.{css,ico,js,jpeg,png,svg}'],
        },
        manifest: {
          id: '/',
          name: env.APP_NAME,
          short_name: env.APP_NAME,
          start_url: '/',
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
              src: '/vendor/creasico/favicon.svg',
              sizes: '512x512',
              type: 'image/svg+xml',
            },
            {
              src: '/vendor/creasico/icon-192x192.png',
              sizes: '192x192',
              type: 'image/png',
            },
            {
              src: '/vendor/creasico/icon-512x512.png',
              sizes: '512x512',
              type: 'image/png',
            },
            {
              src: '/vendor/creasico/icon-512x512.png',
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
