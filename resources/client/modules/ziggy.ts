import { ZiggyVue } from 'ziggy/vue'
import { Ziggy } from '~/ziggy.cjs'

export const install: AppModuleInstall = ({ app }): void => {
  app.use(ZiggyVue, Ziggy)
}
