import { defineConfig } from 'windicss/helpers'
// import colors from 'windicss/colors'
// import defaultTheme from 'windicss/defaultTheme'

export default defineConfig({
  extract: {
    include: [
      'resources/client/**/*.{vue,js,ts}',
      'resources/views/**/*.blade.php',
    ],
    exclude: ['node_modules', '.git'],
  },
  plugins: [
    require('windicss/plugin/typography'),
    require('windicss/plugin/forms'),
    require('windicss/plugin/filters'),
    require('windicss/plugin/line-clamp'),
  ],
  safelist: ['prose', 'prose-sm', 'max-w-none', 'hidden'],
  theme: {
    extend: {
      colors: {
        // DEFAULT: colors.emerald.toString(),
        primary: {
          DEFAULT: '#388370',
        },
        secondary: {
          DEFAULT: '#839F98',
        },
      },
      fontFamily: {
        sans: ['Nunito', 'sans-serif'],
        // serif: [...defaultTheme.fontFamily.serif],
        // mono: [...defaultTheme.fontFamily.mono],
      },
    },
  },
})
