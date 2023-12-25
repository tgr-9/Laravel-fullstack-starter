import { registerSW } from 'virtual:pwa-register'
import { registerMessagingToken } from './firebase'

export const install: AppModuleInstall = async ({ app, isClient }) => {
  if (!isClient)
    return

  /**
   * Request for notification permissions.
   *
   * **Note:** In MS Edge, the permission request will be blocked by the browser.
   */
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

  const { $message, $notification, $t } = app.config.globalProperties

  /**
   * Listen to background messages.
   */
  navigator.serviceWorker.addEventListener('message', ({ data }) => {
    /**
     * Forward the notification to foreground when it comes from background firebase messaging.
     */
    if (data.isFirebaseMessaging) {
      $notification.info({
        title: data.notification.title,
        content: data.notification.body,
      })
    }
  })

  registerSW({
    immediate: true,
    async onRegisteredSW(_, registration) {
      if (!registration)
        return

      await registerMessagingToken(registration)
    },
    onRegisterError(error) {
      console.error('SW registration failed: ', error)
    },
    onNeedRefresh() {
      $message.info($t('dashboard.update-notice'), {
        duration: 0,
        closable: true,
        async onClose() {
          const reg = await navigator.serviceWorker.getRegistration()

          reg?.active?.postMessage({ type: 'SKIP_WAITING' })

          await reg?.update()
        },
      })
    },
  })
}
