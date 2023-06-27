import { createInertiaApp } from '@inertiajs/vue3'
import { BrowserTracing, init } from '@sentry/vue'
import naive from 'naive-ui'
import { createI18n } from 'vue-i18n'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { ZiggyVue } from 'ziggy/vue'

// import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

import '~/bootstrap'
import { Ziggy } from '~/ziggy.cjs'
import AppLayout from '~/layouts/app-layout.vue'

const locale = document.documentElement.lang

createInertiaApp({
  title: title => [title, import.meta.env.APP_NAME].filter((str?: string) => !!str).join(' | '),
  resolve: (name) => {
    const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: true })
    const page = pages[`./pages/${name}.vue`]

    page.default.layout = page.default.layout || AppLayout

    return page
  },
  setup({ el, App, props, plugin }) {
    const i18n = createI18n({
      legacy: false,
      locale,
      messages: {},
    })

    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(i18n)
      .use(naive)

    if (import.meta.env.VITE_SENTRY_DSN) {
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

    app.mount(el)
  },
})
