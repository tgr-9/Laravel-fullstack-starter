import { getMessagingToken } from './firebase'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  const { registerSW } = await import('virtual:pwa-register')

  registerSW({
    immediate: true,
    async onRegisteredSW(_, registration) {
      if (!registration) {
        console.warn('Registration failed')
        return
      }

      try {
        await getMessagingToken(registration)
      }
      catch (e) {
        console.error(e)
      }
    },
    onRegisterError(error) {
      console.error('SW registration failed: ', error)
    },
    onNeedRefresh() {
      app.config.globalProperties.$message.info('Your app is updated, please reload the page', {
        duration: 10000,
        onClose() {
          location.reload()
        },
      })
    },
    onOfflineReady() {
      app.config.globalProperties.$message.info('Your app is offline ready')
    },
  })
}
