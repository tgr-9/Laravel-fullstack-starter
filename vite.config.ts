import { resolve } from 'node:path'
import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import windicss from 'vite-plugin-windicss'
import { VitePWA as pwa } from 'vite-plugin-pwa'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, '.', ['APP', 'VITE'])

  return {
    resolve: {
      alias: {
        '~/': `${resolve(__dirname, 'resources/client')}/`,
      },
    },

    plugins: [
      /**
       * @see https://laravel.com/docs/vite
       */
      laravel({
        input: [
          'resources/client/app.ts',
        ],
        refresh: true,
      }),

      /**
       * @see https://windicss.org/integrations/vite.html
       */
      windicss(),

      /**
       * @see https://vite-pwa-org.netlify.app/guide
       */
      pwa({
        injectRegister: 'script',
        registerType: 'autoUpdate',
        devOptions: {
          enabled: mode !== 'production',
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
          start_url: env.APP_URL,
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
