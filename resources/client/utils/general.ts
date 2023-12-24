import type { BasicColorSchema, RemovableRef } from '@vueuse/core'

/**
 * A `console.log(...args)` wrapper that should only work while development.
 */
export function logger(...args: any) {
  if (import.meta.env.DEV)
    console.log.apply(null, args) // eslint-disable-line no-console
}

/**
 * Global application preference.
 */
export interface AppPreference {
  locale: AppLocale | string
  theme: BasicColorSchema
  deviceToken?: string
}

/**
 * State of global application preference.
 */
export const appPreference: RemovableRef<AppPreference> = useLocalStorage<AppPreference>('app-preference', {
  locale: document.documentElement.lang,
  theme: 'auto',
})
