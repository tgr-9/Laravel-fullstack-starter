import { registerSW } from 'virtual:pwa-register'
import { getMessagingToken } from './firebase'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  const { $message, $notification } = app.config.globalProperties
  const { t } = useI18n()

  navigator.serviceWorker.addEventListener('message', ({ data }) => {
    console.info('Background Message Received:', data) // eslint-disable-line no-console

    if (data.type === 'notification') {
      $notification.info({
        title: data.notification.title,
        content: data.notification.body,
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
      if (!registration)
        return

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
      $message.info(t('dashboard.update-notice'), {
        duration: 0,
        closable: true,
        async onClose() {
          navigator.serviceWorker.controller?.postMessage({ type: 'SKIP_WAITING' })
        },
      })
    },
  })
}
