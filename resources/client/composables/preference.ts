import { useDark, useSessionStorage } from '@vueuse/core'
import type { RemovableRef } from '@vueuse/core'
import { darkTheme, dateEnUS, dateIdID, enUS, idID } from 'naive-ui'
import type { GlobalTheme, NDateLocale, NLocale } from 'naive-ui'

export interface AppPreference {
  locale: string
}

export interface MenuPreference {
  collapsed: boolean
  activeKey?: string
  expandedKeys: string[]
}

interface NaiveConfig {
  theme: GlobalTheme | null
  locale: NLocale
  dateLocale: NDateLocale
}

export const appPreference: RemovableRef<AppPreference> = useSessionStorage<AppPreference>('app-preference', {
  locale: document.documentElement.lang,
})

export const menuPreference: RemovableRef<MenuPreference> = useSessionStorage<MenuPreference>('menu-preference', {
  collapsed: false,
  expandedKeys: [],
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
