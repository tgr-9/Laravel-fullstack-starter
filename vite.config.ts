import { resolve } from 'path'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import windicss from 'vite-plugin-windicss'

export default defineConfig({
  resolve: {
    alias: {
      '~/': `${resolve(__dirname, 'resources/client')}/`,
    },
  },

  plugins: [
    laravel({
      input: [
        'resources/client/app.ts',
      ],
      refresh: true,
    }),

    windicss(),
  ],
})
