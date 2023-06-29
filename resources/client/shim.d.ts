import type { AxiosStatic } from 'axios'
import type Router from 'ziggy/Router'
import { Ziggy } from '~/ziggy.cjs'

export {}

type ZiggyRoutes = typeof Ziggy.routes

declare global {
  const axios: AxiosStatic
  function route(): Router
  function route(name: keyof ZiggyRoutes, params?: Record<string, any>, absolute?: boolean): string

  interface Window {
    axios: AxiosStatic
  }
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $route: typeof route
    $axios: AxiosStatic
  }
}
