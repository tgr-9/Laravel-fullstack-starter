import { createI18n } from 'vue-i18n'
import messages from '@intlify/unplugin-vue-i18n/messages'

export const install: AppModuleInstall = ({ app, isClient }): void => {
  type Value = string | string[] | null

  const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang,
    messages,
  })

  if (isClient) {
    for (const [locale, translations] of Object.entries(window.__translations)) {
      const message: Record<string, any> = {}

      for (let [key, value] of Object.entries<Value>(translations)) {
        if (typeof value !== 'string')
          continue

        if (value.includes('@') && import.meta.env.DEV)
          value = value.replace(/\@/g, '{\'@\'}')

        if (value.includes(':'))
          value = value.replace(/:(\w+)/g, (_: string, ...args: any[]) => `{${args[0].toLowerCase()}}`)

        message[key] = value
      }

      i18n.global.setLocaleMessage(locale, message)
    }
  }

  app.use(i18n)
}

declare global {
  interface Window {
    __translations: Record<AppLocale, any>
  }
}
