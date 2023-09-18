import type { PageProps, Page } from '@inertiajs/core'
import type { App } from 'vue'
import { DefineLocaleMessage, VueI18nResolveLocaleMessageTranslation } from 'vue-i18n'

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

declare module '@vue/runtime-core' {
  /**
   * Component Custom Options for page components
   */
  export interface ComponentCustomOptions {
    /**
     * Define layout title
     */
    layoutName?: string

    /**
     * Define page name
     */
    pageName?: string
  }
}

declare module '@inertiajs/vue3' {
  export function usePage<T extends AppPageProps>(): Page<T>
}
