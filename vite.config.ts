import { resolve } from 'node:path'
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
  const env = loadEnv(mode, '.', ['APP', 'FIREBASE', 'SENTRY', 'VITE'])
  const rootDir = 'resources/client'
  const appURL = new URL(env.APP_URL)
  const isDev = ['local', 'testing'].includes(env.APP_ENV)

  const firebaseConfig = {
    projectId: env.FIREBASE_PROJECT_ID,
    appId: env.FIREBASE_APP_ID,
    apiKey: env.FIREBASE_API_KEY,
    authDomain: `${env.FIREBASE_PROJECT_ID}.firebaseapp.com`,
    databaseURL: env.FIREBASE_DATABASE_URL,
    storageBucket: `${env.FIREBASE_PROJECT_ID}.appspot.com`,
    messagingSenderId: env.FIREBASE_MESSAGING_SENDER_ID,
  }

  /**
   * Define the icons that:
   * 1. We want to include in the webmanifest, and
   * 2. We want to service worker to pre-cache for offline use.
   */
  const manifestIcons = [
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
  ]

  /**
   * Define the icons that:
   * 1. We don't need in the webmanifest, and
   * 2. We want to service worker to pre-cache for offline use.
   */
  const publicIcons = [
    { src: '/favicon.ico' },
    { src: '/vendor/creasico/apple-touch-icon.png' },
  ]

  return {
    resolve: {
      alias: {
        '~': resolve(__dirname, rootDir),
      },
    },

    optimizeDeps: {
      include: [],
      exclude: [
        'vue-demi',
      ],
    },

    build: {
      sourcemap: isDev || 'SENTRY_AUTH_TOKEN' in env,
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
      'FIREBASE_CONFIG': JSON.stringify(firebaseConfig),
      'import.meta.env.APP_NAME': JSON.stringify(env.APP_NAME),
      'import.meta.env.APP_LOCALE': JSON.stringify(env.APP_LOCALE),
      'import.meta.env.APP_URL': JSON.stringify(env.APP_URL),
      'import.meta.env.APP_ENV': JSON.stringify(env.APP_ENV),
      'import.meta.env.FIREBASE_VAPID_KEY': JSON.stringify(env.FIREBASE_VAPID_KEY),
      'import.meta.env.SENTRY_DSN': JSON.stringify(env.SENTRY_DSN),
      'import.meta.env.SENTRY_PROFILING_ENABLE': Boolean(env.SENTRY_PROFILING_ENABLE ?? 0),
    },

    server: {
      host: appURL.host,
      hmr: { host: appURL.host },
      https: httpsCert(appURL),
    },

    plugins: [
      vue(),

      /**
       * @see https://laravel.com/docs/vite
       */
      laravel({
        input: [
          `${rootDir}/app.ts`,
        ],
        // valetTls: env.APP_ENV === 'local' && env.APP_URL.startsWith('https://'),
        // refresh: true,
      }),

      /**
       * @see https://www.npmjs.com/package/@sentry/vite-plugin
       */
      sentryVitePlugin({
        disable: !('SENTRY_AUTH_TOKEN' in env),
        org: env.SENTRY_ORG,
        project: env.SENTRY_PROJECT,
        authToken: env.SENTRY_AUTH_TOKEN,
        telemetry: !isDev,
      }),

      /**
       * @see https://windicss.org/integrations/vite.html
       */
      windicss(),

      /**
       * @see https://github.com/antfu/unplugin-auto-import
       */
      autoImport({
        dts: `${rootDir}/auto-imports.d.ts`,
        dirs: [
          `${rootDir}/utils`,
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
        dts: `${rootDir}/components.d.ts`,
        dirs: [
          `${rootDir}/components`,
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
        buildBase: '/build/',
        devOptions: {
          // enabled: (mode !== 'production' && !!env.APP_DEBUG),
        },
        includeAssets: [],
        manifest: {
          id: '/',
          name: env.APP_NAME,
          short_name: env.APP_NAME,
          start_url: '/',
          lang: env.APP_LOCALE || 'id',
          scope: '/',
          orientation: 'any',
          icons: manifestIcons,
        },
        scope: '/',
        srcDir: rootDir,
        workbox: {
          additionalManifestEntries: [
            // Cache the root URL to get hold of the PWA HTML entrypoint
            // https://github.com/vite-pwa/vite-plugin-pwa/issues/431#issuecomment-1703151065
            { url: '/', revision: `${Date.now()}` },

            // Cache the icons defined above for the manifest
            ...manifestIcons.map(i => ({ url: i.src, revision: `${Date.now()}` })),

            // Cache the other offline icons defined above
            ...publicIcons.map(i => ({ url: i.src, revision: `${Date.now()}` })),
          ],
          globPatterns: ['**/*.{css,ico,js,jpeg,png,svg,woff2}'],
          navigateFallback: '/',
          skipWaiting: true,
        },
      }),
    ],
  }
})

function httpsCert(url: URL) {
  if (url.protocol !== 'https:')
    return undefined

  try {
    return {
      cert: resolve(__dirname, 'storage/local-cert.pem'),
      key: resolve(__dirname, 'storage/local-key.pem'),
    }
  }
  catch {
    return undefined
  }
}
