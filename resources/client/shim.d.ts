import type Router from 'ziggy/Router'
import { Ziggy } from '~/ziggy.cjs'

export {}

type ZiggyRoutes = typeof Ziggy.routes

declare global {
  function route(): Router
  function route(name: keyof ZiggyRoutes, params?: Record<string, any>, absolute?: boolean): string
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $route: typeof route
  }
}
