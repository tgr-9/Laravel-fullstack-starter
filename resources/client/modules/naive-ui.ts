import type { DialogApi, LoadingBarApi, MessageApi, NotificationApi } from 'naive-ui'
import { createDiscreteApi } from 'naive-ui'

export const install: AppModuleInstall = ({ app, isClient }): void => {
  if (!isClient)
    return

  const configProviderProps = useNaiveConfig()
  const { message, dialog, notification, loadingBar } = createDiscreteApi(
    ['message', 'dialog', 'notification', 'loadingBar'],
    { configProviderProps },
  )

  app.provide('$message', message)
  app.provide('$dialog', dialog)
  app.provide('$notification', notification)
  app.provide('$loading', loadingBar)

  app.config.globalProperties.$message = message
  app.config.globalProperties.$dialog = dialog
  app.config.globalProperties.$notification = notification
  app.config.globalProperties.$loading = loadingBar
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $message: MessageApi
    $dialog: DialogApi
    $notification: NotificationApi
    $loading: LoadingBarApi
  }
}
