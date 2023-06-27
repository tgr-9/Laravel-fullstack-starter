import type { RemovableRef } from '@vueuse/core'

interface SitePreference {
  locale: string
  menuOpened: boolean
}

export const sitePreference: RemovableRef<SitePreference> = useSessionStorage<SitePreference>('site-preference', {
  locale: 'id',
  menuOpened: false,
})
