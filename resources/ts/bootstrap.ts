import axios from 'axios'
import type { AxiosResponse } from 'axios'
import * as Sentry from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '../css/app.css'

const scrollTop = (response: AxiosResponse) => {
  document.body.scrollTop = 0 // For Safari
  document.documentElement.scrollTop = 0 // For Chrome, Firefox, IE and Opera

  return response
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true
axios.interceptors.response.use(response => scrollTop(response), (error) => {
  if (error.response.status === 401)
    window.location.replace('/login')

  if (error.response.status === 422)
    return error.response

  // whatever you want to do with the error
  console.error('error bro', error.response)

  throw error
})

Sentry.init({
  dsn: import.meta.env.VITE_SENTRY_DSN,
  integrations: [new BrowserTracing()],

  // Set tracesSampleRate to 1.0 to capture 100%
  // of transactions for performance monitoring.
  // We recommend adjusting this value in production
  tracesSampleRate: import.meta.env.VITE_SENTRY_TRACES_SAMPLE_RATE,
})

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
