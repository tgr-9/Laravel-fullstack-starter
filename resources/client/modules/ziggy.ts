import type { Config } from 'ziggy-js'
import route from 'ziggy-js'

import { Ziggy } from '~/ziggy.cjs'

export type AppRoutes = typeof Ziggy.routes

export const install: AppModuleInstall = ({ app }): void => {
  const r = (name: any, params: any, absolute: any) => {
    return route(name, params, absolute, Ziggy as Config)
  }

  app.config.globalProperties.$route = window.route = r as typeof route

  // app.provide('route', () => {})

  // app.use(ZiggyVue, Ziggy)
}
