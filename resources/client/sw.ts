/// <reference no-default-lib="true"/>
/// <reference lib="WebWorker" />

import { cacheNames, clientsClaim } from 'workbox-core'
import { cleanupOutdatedCaches, precacheAndRoute } from 'workbox-precaching'
import { setDefaultHandler } from 'workbox-routing'
import { CacheFirst } from 'workbox-strategies'

declare let self: ServiceWorkerGlobalScope & Record<string, any>
const cacheName = cacheNames.runtime

cleanupOutdatedCaches()

setDefaultHandler(new CacheFirst({ cacheName }))

precacheAndRoute(self.__WB_MANIFEST)

self.addEventListener('fetch', (e) => {
  console.log(e.request.url) // eslint-disable-line no-console
})

self.skipWaiting()

clientsClaim()
