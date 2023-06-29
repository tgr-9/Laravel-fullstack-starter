import { createI18n } from 'vue-i18n'
import messages from '@intlify/unplugin-vue-i18n/messages'

export const install: AppModuleInstall = ({ app }): void => {
  for (const [locale, translations] of Object.entries(window.__translations)) {
    const trans: Record<string, any> = {}

    for (const [key, value] of Object.entries<string>(translations)) {
      trans[key] = value.includes(':')
        ? value.replace(/:(\w+)/g, (_: string, ...args: any[]) => `{${args[0].toLowerCase()}}`)
        : value
    }

    messages[locale] = Object.assign({}, messages[locale], trans)
  }

  const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang,
    messages,
  })

  app.use(i18n)
}
