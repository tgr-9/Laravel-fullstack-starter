import type { BasicColorSchema, RemovableRef } from '@vueuse/core'
import { darkTheme, dateEnUS, dateIdID, enUS, idID, lightTheme } from 'naive-ui'
import type { ConfigProviderProps, DialogApi, GlobalThemeOverrides, LoadingBarApi, MessageApi, NDateLocale, NLocale, NotificationApi } from 'naive-ui'

/**
 * Global application preference.
 */
export interface AppPreference {
  locale: AppLocale | string
  theme: BasicColorSchema
}

/**
 * State of global application preference.
 */
export const appPreference: RemovableRef<AppPreference> = useSessionStorage<AppPreference>('app-preference', {
  locale: document.documentElement.lang,
  theme: 'auto',
})

const themeOverrides: GlobalThemeOverrides = {}

const isDark = useDark({
  initialValue: appPreference.value.theme,
  onChanged(isDark, handler, mode) {
    appPreference.value.theme = isDark ? 'dark' : 'light'

    handler(mode)
  },
})

export const toggleTheme = useToggle(isDark)

/**
 * Override default naive-ui theme.
 *
 * @see https://www.naiveui.com/en-US/os-theme/docs/customize-theme
 * @param overrides
 */
export function createThemeOverrides(overrides: GlobalThemeOverrides): void {
  Object.assign(themeOverrides, overrides)
}

/**
 * Use naive-ui Discrete API
 */
export function useNaiveDiscreteApi() {
  return {
    message: inject('$message') as MessageApi,
    notification: inject('$notification') as NotificationApi,
    dialog: inject('$dialog') as DialogApi,
    loading: inject('$loading') as LoadingBarApi,
  }
}

/**
 * Use naive-ui configuration
 */
export function useNaiveConfig(): ConfigProviderProps {
  const theme = computed(() => appPreference.value.theme === 'dark' ? darkTheme : lightTheme)

  const locales: { [k in string]: NLocale } = {
    id: idID,
    en: enUS,
  }

  const dateLocales: { [k in string]: NDateLocale } = {
    id: dateIdID,
    en: dateEnUS,
  }

  return {
    theme: theme.value,
    themeOverrides,
    locale: locales[appPreference.value.locale],
    dateLocale: dateLocales[appPreference.value.locale],
  }
}
