import alpine from 'alpinejs'
import type { Alpine } from 'alpinejs'
import axios from 'axios'
import type { AxiosError, AxiosStatic } from 'axios'
import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'
import * as Sentry from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

declare global {
  interface Window {
    Alpine: Alpine
    axios: AxiosStatic
    dateFormat: (date: Date, fmt: string) => string
    numberFormat: (num: number) => string
    Livewire?: any
    // extend the window
  }
}

// import TimeAgo from './util/timeago'
const {
  VITE_SENTRY_DSN,
  VITE_SENTRY_TRACES_SAMPLE_RATE,
} = import.meta.env

if (VITE_SENTRY_DSN) {
  Sentry.init({
    dsn: VITE_SENTRY_DSN,
    integrations: [new BrowserTracing()],

    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: VITE_SENTRY_TRACES_SAMPLE_RATE,
  })
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true
axios.interceptors.response.use(response => response, (error: AxiosError) => {
  if (error.response?.status === 401)
    window.location.replace('/login')

  if (error.response?.status === 422)
    return error.response

  // whatever you want to do with the error
  Sentry.captureException(error)
})

if (import.meta.env.VITE_API_URL)
  axios.defaults.baseURL = import.meta.env.VITE_API_URL

window.Alpine = alpine
window.axios = axios

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
