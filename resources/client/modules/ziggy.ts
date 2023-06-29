import { ZiggyVue } from 'ziggy/vue'
import { Ziggy } from '~/ziggy.cjs'

export const install: AppModuleInstall = ({ app }): void => {
  app.config.globalProperties.$route = route

  app.use(ZiggyVue, Ziggy)
}
