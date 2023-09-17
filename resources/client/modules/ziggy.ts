import type { Config } from 'ziggy-js'
import ziggyRoute from 'ziggy-js'

import { Ziggy } from '~/ziggy.cjs'

declare global {
  const route: typeof ziggyRoute

  interface Window {
    route: typeof ziggyRoute
  }
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $route: typeof ziggyRoute
  }
}

declare module 'ziggy-js' {
  export default function route(
    name: keyof AppRoutes,
    params?: RouteParamsWithQueryOverload | RouteParam,
    absolute?: boolean,
    config?: Config
  ): string
}

export type AppRoutes = typeof Ziggy.routes

export const install: AppModuleInstall = ({ app }): void => {
  const route = (name: keyof AppRoutes, params: any, absolute: boolean) => {
    return ziggyRoute(name, params, absolute, Ziggy as Config)
  }

  app.config.globalProperties.$route = window.route = route as typeof ziggyRoute
}
