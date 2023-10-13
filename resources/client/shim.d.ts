import type { App } from 'vue'

export {}

interface AppMessage {
  type?: "warning" | "error" | "info" | "success"
  title: string
  description: string
}

interface AppUser {
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

declare module '@inertiajs/core' {
  export interface PageProps {
    user: AppUser | null
    message: AppMessage | null
  }
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
