import { registerSW } from 'virtual:pwa-register'
import { getMessagingToken } from './firebase'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  const { $message, $notification } = app.config.globalProperties

  navigator.serviceWorker.addEventListener('message', ({ data }) => {
    console.info('Background Message Received:', data) // eslint-disable-line no-console
    $notification.info({
      title: data.notification.title,
      content: data.notification.body,
    })
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
      try {
        await getMessagingToken(registration)
        console.info('Registration successful') // eslint-disable-line no-console
      }
      catch (e) {
        const err = e as Error
        console.warn(err.name, ':', err.message)
        // location.reload()
      }
    },
    onRegisterError(error) {
      console.error('SW registration failed: ', error)
    },
    onNeedRefresh() {
      $message.info('The App has been updated, please reload the page', {
        duration: 10000,
        onClose() {
          location.reload()
        },
      })
    },
  })
}
