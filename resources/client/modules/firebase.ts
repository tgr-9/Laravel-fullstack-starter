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

/**
 * Register new device token.
 */
export async function registerMessagingToken(registration: ServiceWorkerRegistration): Promise<void> {
  if (!import.meta.env.FIREBASE_VAPID_KEY)
    throw new Error('No "FIREBASE_VAPID_KEY" environment variable set.')

  if (appPreference.value.deviceToken)
    return

  if (!instance.messaging)
    instance.messaging = getMessaging(instance.app)

  /**
   * As of now, the implementation is this function will be called when user visit the page,
   * or when the user refresh the page.
   */
  try {
    appPreference.value.deviceToken = await getToken(instance.messaging, {
      vapidKey: import.meta.env.FIREBASE_VAPID_KEY,
      serviceWorkerRegistration: registration,
    })
  }
  catch (e) {
    const err = e as Error
    console.warn(err.name, ':', err.message)
  }
}

declare global {
  const FIREBASE_CONFIG: FirebaseOptions
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $firebaseApp: FirebaseApp
  }
}
