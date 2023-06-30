import { useDark, useSessionStorage } from '@vueuse/core'
import type { RemovableRef } from '@vueuse/core'
import { darkTheme, dateEnUS, dateIdID, enUS, idID } from 'naive-ui'
import type { GlobalTheme, NDateLocale, NLocale } from 'naive-ui'

interface SitePreference {
  locale: string
  menuOpened: boolean
}

interface NaiveConfig {
  theme: GlobalTheme | null
  locale: NLocale
  dateLocale: NDateLocale
}

export const sitePreference: RemovableRef<SitePreference> = useSessionStorage<SitePreference>('site-preference', {
  locale: 'id',
  menuOpened: false,
})

export function useNaiveConfig(): NaiveConfig {
  const i18n = useI18n()
  const isDark = useDark()

  const locales: { [k in AppLocale]: NLocale } = {
    id: idID,
    en: enUS,
  }

  const dateLocales: { [k in AppLocale]: NDateLocale } = {
    id: dateIdID,
    en: dateEnUS,
  }

  const lang = i18n.locale.value as AppLocale

  return {
    theme: isDark ? darkTheme : null,
    locale: locales[lang],
    dateLocale: dateLocales[lang],
  }
}
