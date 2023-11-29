import type { FirebaseApp, FirebaseOptions } from 'firebase/app'
import { initializeApp } from 'firebase/app'
import { type Messaging, getMessaging, getToken } from 'firebase/messaging'

export interface FirebaseInstances {
  app?: FirebaseApp
  messaging?: Messaging
}

const instance: FirebaseInstances = {}

export const install: AppModuleInstall = async ({ app, isClient }): Promise<void> => {
  if (!isClient)
    return

  const $app = instance.app = initializeApp(FIREBASE_CONFIG)

  app.config.globalProperties.$firebaseApp = $app

  if (!instance.messaging)
    instance.messaging = getMessaging(instance.app)
}

export async function getMessagingToken(registration?: ServiceWorkerRegistration): Promise<string> {
  if (!import.meta.env.FIREBASE_VAPID_KEY)
    throw new Error('No "FIREBASE_VAPID_KEY" environment variable set.')

  if (!instance.messaging)
    instance.messaging = getMessaging(instance.app)

  if (!appPreference.value.deviceToken) {
    appPreference.value.deviceToken = await getToken(instance.messaging, {
      vapidKey: import.meta.env.FIREBASE_VAPID_KEY,
      serviceWorkerRegistration: registration,
    })
  }

  return appPreference.value.deviceToken
}

declare global {
  const FIREBASE_CONFIG: FirebaseOptions
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $firebaseApp: FirebaseApp
  }
}
