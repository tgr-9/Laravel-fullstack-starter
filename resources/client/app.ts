import alpine from 'alpinejs'
import type { Alpine } from 'alpinejs'
import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'

// import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

import '~/libs/sentry'
import '~/libs/axios'

declare global {
  interface Window {
    Alpine: Alpine
    dateFormat: (date: Date, fmt: string) => string
    numberFormat: (num: number) => string
  }
}

window.Alpine = alpine

const locales: { [key in string]: Locale } = { id, en }
const locale = locales[document.documentElement.lang]

window.dateFormat = (date: Date, fmt: string) => {
  return format(date, fmt, { locale })
}

window.numberFormat = (num: number) => {
  return new Intl.NumberFormat(document.documentElement.lang).format(num)
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: import.meta.env.VITE_PUSHER_APP_KEY,
//   cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//   forceTLS: true
// });

// Alpine.plugin(TimeAgo.configure({ locale }))

// const dataLayer = window.dataLayer || []
// const gtag = window.gtag = (...args) => dataLayer.push(args)

window.addEventListener('DOMContentLoaded', () => {
  // gtag('js', new Date())
  // gtag('config', 'G-1KQP24LR0L')

  alpine.start()
})
