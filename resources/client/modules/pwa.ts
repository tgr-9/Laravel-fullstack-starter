import { useRegisterSW } from 'virtual:pwa-register/vue'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  const { offlineReady } = useRegisterSW({
    immediate: true,
  })

  const { registerSW } = await import('virtual:pwa-register')

  if (offlineReady.value) {
    logger(offlineReady.value)
    app.config.globalProperties.$message.info('Your app is offline ready')
  }

  registerSW({
    immediate: true,
  })
}
