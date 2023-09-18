import type { BasicColorSchema, RemovableRef } from '@vueuse/core'
import type { ComputedRef } from 'vue'
import { darkTheme, dateEnUS, dateIdID, enUS, idID } from 'naive-ui'
import type { GlobalTheme, GlobalThemeOverrides, NDateLocale, NLocale } from 'naive-ui'

/**
 * Global application preference.
 */
export interface AppPreference {
  locale: AppLocale | string
  theme: BasicColorSchema
}

/**
 * Naive-ui config-provider values.
 *
 * @see https://www.naiveui.com/en-US/os-theme/components/config-provider
 */
interface NaiveConfig {
  theme: ComputedRef<GlobalTheme | null>
  themeOverrides: GlobalThemeOverrides
  locale: NLocale
  dateLocale: NDateLocale
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
 * Use naive-ui configuration
 */
export function useNaiveConfig(): NaiveConfig {
  const i18n = useI18n()
  const theme = computed(() => appPreference.value.theme === 'dark' ? darkTheme : null)

  const locales: { [k in string]: NLocale } = {
    id: idID,
    en: enUS,
  }

  const dateLocales: { [k in string]: NDateLocale } = {
    id: dateIdID,
    en: dateEnUS,
  }

  return {
    theme,
    themeOverrides,
    locale: locales[i18n.locale.value],
    dateLocale: dateLocales[i18n.locale.value],
  }
}
