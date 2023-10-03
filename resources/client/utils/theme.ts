import { darkTheme, dateEnUS, dateIdID, enUS, idID, lightTheme } from 'naive-ui'
import type { ConfigProviderProps, DialogApi, GlobalThemeOverrides, LoadingBarApi, MessageApi, NDateLocale, NLocale, NotificationApi } from 'naive-ui'

const themeOverrides: GlobalThemeOverrides = {}

/**
 * @see https://vueuse.org/core/useDark
 */
const isDark = useDark({
  initialValue: appPreference.value.theme,
  onChanged(isDark, handler, mode) {
    appPreference.value.theme = isDark ? 'dark' : 'light'

    handler(mode)
  },
})

/**
 * @see https://vueuse.org/shared/useToggle
 */
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
