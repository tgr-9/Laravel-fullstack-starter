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

  app.provide('$message', readonly(message))
  app.provide('$dialog', readonly(dialog))
  app.provide('$notification', readonly(notification))
  app.provide('$loading', readonly(loadingBar))

  app.config.globalProperties.$message = message
  app.config.globalProperties.$dialog = dialog
  app.config.globalProperties.$notification = notification
  app.config.globalProperties.$loading = loadingBar
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $message: MessageApi
    $dialog: DialogApi
    $notification: NotificationApi
    $loading: LoadingBarApi
  }
}
