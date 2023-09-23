import type { PageProps, Page } from '@inertiajs/core'
import type { App } from 'vue'

export {}

interface AppPageProps extends PageProps {
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

declare global {
  type AppLocale = 'id' | 'en'

  /**
   * Application module install function.
   */
  type AppModuleInstall = (ctx: AppModuleContext) => void

  interface AppModuleContext {
    app: App<Element>
    isClient: boolean
  }
}

declare module '@inertiajs/vue3' {
  export function usePage<T extends AppPageProps>(): Page<T>
}

declare module '@vue/runtime-core' {
  /**
   * Component Custom Options for page components
   */
  export interface ComponentCustomOptions {
    /**
     * Name of layout component to use in current page
     */
    layoutName?: string

    /**
     * Define current page name based on existing translation key
     */
    pageName?: string

    /**
     * Define current page title
     */
    pageTitle?: string

    /**
     * Define paths of current page
     */
    breadcrumb?: string[]
  }
}
