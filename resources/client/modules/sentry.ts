import { BrowserTracing, init } from '@sentry/vue'

export const install: AppModuleInstall = ({ app }): void => {
  if (!import.meta.env.VITE_SENTRY_DSN)
    return

  init({
    app,
    dsn: import.meta.env.VITE_SENTRY_DSN,
    environment: import.meta.env.APP_ENV,
    integrations: [new BrowserTracing()],
    trackComponents: true,
    tracesSampleRate: 1.0,
    logErrors: true,
  })
}
