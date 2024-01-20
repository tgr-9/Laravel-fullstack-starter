import { initializeApp } from 'firebase/app'
import { getMessaging, onBackgroundMessage } from 'firebase/messaging/sw'
import type { PrecacheEntry } from 'workbox-precaching'
import { cleanupOutdatedCaches, precacheAndRoute } from 'workbox-precaching'
import { cacheNames, clientsClaim } from 'workbox-core'
import { registerRoute, setDefaultHandler } from 'workbox-routing'
import { NetworkFirst, StaleWhileRevalidate } from 'workbox-strategies'

declare let self: ServiceWorkerGlobalScope & Record<string, any>

const manifest = self.__WB_MANIFEST as PrecacheEntry[]
const { revision } = manifest.find(entry => entry.url === 'manifest.webmanifest') as PrecacheEntry

manifest.unshift(
  { revision, url: '/' },
  { revision, url: '/favicon.ico' },
)

/**
 * Initialize Caching mechanism.
 */
cleanupOutdatedCaches()

setDefaultHandler(new StaleWhileRevalidate({
  cacheName: cacheNames.precache,
}))

precacheAndRoute(manifest)

registerRoute(
  ({ request }) => request.destination === 'document',
  new NetworkFirst({ cacheName: cacheNames.runtime }),
)

/**
 * Initialize Firebase App.
 */
initializeApp(FIREBASE_CONFIG)

const messaging = getMessaging()

/**
 * Handles background messages.
 *
 * Meaning this listener will only triggered when the app is not in the foreground.
 * Or perhabs the app is openned but bot focused by the user.
 */
onBackgroundMessage(messaging, ({ notification, fcmOptions }) => {
  if (!notification)
    return

  self.registration.showNotification(notification.title!, {
    body: notification.body,
    icon: notification.icon || '/favicon.ico',
    badge: '/vendor/creasico/icon-192x192.png',
    lang: 'id',
    data: {
      url: fcmOptions?.link || '/',
    },
  })
})

/**
 * Handles a notification click event
 */
self.addEventListener('notificationclick', (e) => {
  e.waitUntil(self.clients.matchAll({ type: 'window' }).then((clients) => {
    if (clients.length === 0) {
      self.clients.openWindow('/')
      return
    }

    // This part still now working as expected
    clients[0].focus()
  }))

  e.notification.close()
})

self.skipWaiting()
clientsClaim()
