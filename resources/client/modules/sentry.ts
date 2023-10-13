import { BrowserProfilingIntegration, BrowserTracing, Replay, init } from '@sentry/vue'

export const install: AppModuleInstall = ({ app }): void => {
  if (!import.meta.env.SENTRY_DSN)
    return

  init({
    app,
    dsn: import.meta.env.SENTRY_DSN,
    environment: import.meta.env.APP_ENV,
    integrations(integrations) {
      integrations.push(
        new BrowserTracing(),
        new Replay({
          maskAllInputs: true,
          maskAllText: false,
          networkDetailAllowUrls: [location.origin],
        }),
      )

      if (import.meta.env.SENTRY_PROFILING_ENABLE)
        integrations.push(new BrowserProfilingIntegration())

      return integrations
    },
    logErrors: true,
    profilesSampleRate: 1.0,
    replaysOnErrorSampleRate: 1.0,
    trackComponents: true,
    tracesSampleRate: 1.0,
  })
}
