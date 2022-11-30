import { init } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

const {
  VITE_SENTRY_DSN,
  VITE_SENTRY_TRACES_SAMPLE_RATE,
} = import.meta.env

if (VITE_SENTRY_DSN) {
  init({
    dsn: VITE_SENTRY_DSN,
    integrations: [new BrowserTracing()],

    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: VITE_SENTRY_TRACES_SAMPLE_RATE,
  })
}
