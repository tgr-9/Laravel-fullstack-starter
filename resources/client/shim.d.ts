import type { Errors, InertiaForm } from '@inertiajs/vue3'
import type { App } from 'vue'

export {}

declare global {
  type AppLocale = 'id' | 'en'

  type GenericModelForm<T> = InertiaForm<T>
  type GenericValidation<T> = Record<keyof T, 'error' | undefined>

  /**
   * Application module install function.
   */
  type AppModuleInstall = (ctx: AppModuleContext) => void

  interface AppModuleContext {
    app: App<Element>
    isClient: boolean
  }
}

declare module 'vue' {
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
    paths?: string[]
  }
}
