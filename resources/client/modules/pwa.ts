import { getMessagingToken } from './firebase'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  const { registerSW } = await import('virtual:pwa-register')
  const { $message, $notification } = app.config.globalProperties

  navigator.serviceWorker.addEventListener('message', ({ data }) => {
    console.info('SW message received: ', data) // eslint-disable-line no-console
    if (data?.type === 'notification') {
      $notification.info({
        title: data.title,
        content: data.body,
      })
    }
  })

  try {
    if (Notification.permission === 'denied')
      throw new Error('Notifications are denied by the user')

    if (Notification.permission === 'default') {
      const permission = await Notification.requestPermission()

      if (permission === 'denied')
        throw new Error('Notifications are denied by the user')
    }
  }
  catch (e) {
    console.warn((e as Error).message)
  }

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
        console.warn((e as Error).message)
      }
    },
    onRegisterError(error) {
      console.error('SW registration failed: ', error)
    },
    onNeedRefresh() {
      $message.info('Your app is updated, please reload the page', {
        duration: 10000,
        onClose() {
          location.reload()
        },
      })
    },
    onOfflineReady() {
      $message.info('Your app is offline ready')
    },
  })
}
