import { useRegisterSW } from 'virtual:pwa-register/vue'

export const install: AppModuleInstall = async ({ isClient }) => {
  if (!isClient)
    return

  const { offlineReady } = useRegisterSW({
    immediate: true,
  })

  const { registerSW } = await import('virtual:pwa-register')

  if (offlineReady.value)
    logger('Offline ready', 'Your app is offline ready')

  registerSW({
    immediate: true,
  })
}
