import { createInertiaApp, router } from '@inertiajs/vue3'
import type { App, DefineComponent } from 'vue'
import { createApp, h } from 'vue'

// import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

import { createThemeOverrides } from '~/utils/preference'
import '~/bootstrap'

interface AppModuleContext {
  app: App<Element>
  isClient: boolean
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
  Space: {
    gapLarge: '24px',
    gapMedium: '16px',
    gapSmall: '9px',
  },
})

const isClient = typeof window !== 'undefined'

if (isClient) {
  window.__inertiaNavigatedCount = window.__inertiaNavigatedCount || 0

  router.on('navigate', () => {
    window.__inertiaNavigatedCount++
  })
}

const layouts = import.meta.glob<DefineComponent>('./layouts/*.vue', { eager: true })
const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: true })

createInertiaApp({
  title: title => [title, import.meta.env.APP_NAME].filter((str?: string) => !!str).join(' | '),
  resolve: async (name) => {
    const page = pages[`./pages/${name}.vue`]

    if (!page)
      throw new Error(`Could not find page component for path '${name}'`)

    const layoutName = page.default.layoutName || 'app-layout'
    const layout = layouts[`./layouts/${layoutName}.vue`]

    if (!layout)
      throw new Error(`Could not find page layout '${layoutName}'`)

    page.default.layout = h(layout.default)

    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props, () => '<div>Test</div>') })
      .use(plugin)

    Object.values(import.meta.glob<{ install: AppModuleInstall }>('./modules/*.ts', { eager: true })).forEach(i =>
      i.install?.({ app, isClient }),
    )

    app.mount(el)
  },
})
