import { createInertiaApp } from '@inertiajs/vue3'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'

// import 'virtual:windi-devtools'
import 'virtual:windi.css'
import '~/app.css'

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
  Breadcrumb: {
    itemLineHeight: 1,
  },
})

const layouts = import.meta.glob<{ default: DefineComponent }>('./layouts/*.vue', { eager: true })
const pages = import.meta.glob<{ default: DefineComponent }>('./pages/**/*.vue', { eager: true })

createInertiaApp({
  title: title => [title, import.meta.env.APP_NAME].filter((str?: string) => !!str).join(' | '),
  resolve: (name) => {
    const page = pages[`./pages/${name}.vue`]

    if (!page)
      throw new Error(`Could not find page component for path '${name}'`)

    const layoutName = page.default.layoutName || 'app-layout'
    const layout = layouts[`./layouts/${layoutName}.vue`]

    if (!layout)
      throw new Error(`Could not find page layout '${layoutName}'`)

    page.default.name = name.replace('/', '-')
    page.default.layout = h(layout.default, { title: page.default.pageName })

    return page
  },
  setup({ el, App, props, plugin }) {
    const isClient = typeof window !== 'undefined'
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)

    Object.values(import.meta.glob<{ install: AppModuleInstall }>('./modules/*.ts', { eager: true })).forEach((i) => {
      Promise.resolve(i.install({ app, isClient }))
    })

    app.mount(el)
  },
})
