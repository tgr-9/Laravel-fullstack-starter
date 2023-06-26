import { BrowserTracing, init } from '@sentry/browser'

if (import.meta.env.VITE_SENTRY_DSN) {
  init({
    dsn: import.meta.env.VITE_SENTRY_DSN,
    integrations: [new BrowserTracing()],

    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: 1.0,
  })
}
