/// <reference no-default-lib="true"/>
/// <reference lib="webworker" />

import type { ManifestEntry } from 'workbox-build'
import { cacheNames, clientsClaim } from 'workbox-core'
import { registerRoute, setDefaultHandler } from 'workbox-routing'
import type { Strategy } from 'workbox-strategies'
import { NetworkFirst, NetworkOnly } from 'workbox-strategies'

declare let self: ServiceWorkerGlobalScope & any
const manifest: ManifestEntry[] = '__WB_MANIFEST' in self
  ? self.__WB_MANIFEST
  : []

const cacheName = cacheNames.runtime
const cacheEntries: RequestInfo[] = []

const manifestURLs = manifest.map((entry) => {
  const url = new URL(entry.url, self.location.toString())

  cacheEntries.push(new Request(url.href, {
    credentials: 'same-origin',
  }))

  return url.href
})

function buildStrategy(): Strategy {
  return new NetworkFirst({ cacheName })
}

self.addEventListener('install', (e: ExtendableEvent) => {
  e.waitUntil(caches.open(cacheName).then(async (cache) => {
    cache.addAll(cacheEntries)
  }))
})

self.addEventListener('activate', (e: ExtendableEvent) => {
  e.waitUntil(caches.open(cacheName).then(async (cache) => {
    const keys = await cache.keys()

    keys.forEach(async (req) => {
      console.info('Checking cache:', req.url) // eslint-disable-line no-console

      if (!manifestURLs.includes(req.url)) {
        const deleted = await cache.delete(req)

        if (deleted)
          console.info('Precached data removed:', req.url) // eslint-disable-line no-console
        else
          console.info('No precached found:', req.url) // eslint-disable-line no-console
      }
    })
  }))
})

registerRoute(({ url }) => manifestURLs.includes(url.href), buildStrategy())

setDefaultHandler(new NetworkOnly())

// setCatchHandler(({ event }) => {
//   // switch (event.request.destination)
// })

self.skipWaiting()
clientsClaim()
