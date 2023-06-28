import { createI18n } from 'vue-i18n'

export const install: AppModuleInstall = ({ app }): void => {
  const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang,
    messages: {},
  })

  app.use(i18n)
}
