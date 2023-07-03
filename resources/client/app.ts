import { createInertiaApp } from '@inertiajs/vue3'
import type { App, DefineComponent } from 'vue'
import { createApp, h } from 'vue'

// import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

import { createThemeOverrides } from '~/utils/preference'
import AppLayout from '~/layouts/app-layout.vue'
import '~/bootstrap'

interface AppModuleContext {
  app: App<Element>
}

declare global {
  /**
   * Application module install function.
   */
  type AppModuleInstall = (ctx: AppModuleContext) => void
}

createThemeOverrides({
  common: {
    primaryColor: '#388370',
    borderRadius: '6px',
    avatarColor: '#388370',
  },
  Layout: {
    color: 'transparent',
  },
})

createInertiaApp({
  title: title => [title, import.meta.env.APP_NAME].filter((str?: string) => !!str).join(' | '),
  resolve: (name) => {
    const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: true })
    const page = pages[`./pages/${name}.vue`]

    if (!page)
      throw new Error(`Could not find page component for path '${name}'`)

    page.default.layout = page.default.layout || AppLayout

    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)

    Object.values(import.meta.glob<{ install: AppModuleInstall }>('./modules/*.ts', { eager: true })).forEach(i =>
      i.install?.({ app }),
    )

    app.mount(el)
  },
})
