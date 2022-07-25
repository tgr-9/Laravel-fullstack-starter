import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import windicss from 'vite-plugin-windicss'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/ts/app.ts',
      ],
      refresh: true,
    }),

    windicss(),
  ],
})
