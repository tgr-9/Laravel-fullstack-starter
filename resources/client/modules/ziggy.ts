import type { Config } from 'ziggy-js'
import ziggyRoute from 'ziggy-js'

import { Ziggy } from '~/ziggy.cjs'

export type AppRoutes = typeof Ziggy.routes

export const install: AppModuleInstall = ({ app }): void => {
  const route = (name: any, params: any, absolute: any) => {
    return ziggyRoute(name, params, absolute, Ziggy as Config)
  }

  app.config.globalProperties.$route = window.route = route as typeof ziggyRoute
}
