import type { AxiosStatic } from 'axios'
import ziggyRoute from 'ziggy-js'
import type { PageProps, Page } from '@inertiajs/core'
import type { RouteParam, RouteParamsWithQueryOverload, Config } from 'ziggy-js'
import type { AppRoutes } from '~/modules/ziggy'

export {}

interface AppPageProps extends PageProps {
  auth: AuthProp
}

interface AuthProp {
  user?: UserProp
  flash: FlashProp
}

interface FlashProp {
  success?: boolean
  errors: array
}

interface UserProp {
  name: string
  email: string
}

declare module '@inertiajs/vue3' {
  export function usePage<T extends AppPageProps>(): Page<T>
}

declare module 'ziggy-js' {
  export default function route(
    name: keyof AppRoutes,
    params?: RouteParamsWithQueryOverload | RouteParam,
    absolute?: boolean,
    config?: Config
  ): string
}

declare global {
  type AppLocale = 'id' | 'en'

  const axios: AxiosStatic
  const route: typeof ziggyRoute

  interface Window {
    axios: AxiosStatic
    route: typeof ziggyRoute
    __translations: Record<AppLocale, any>
  }
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $axios: AxiosStatic
    $route: typeof ziggyRoute
  }
}
