import Alpine from 'alpinejs'
import { format } from 'date-fns'
import { id, enUS as en } from 'date-fns/locale'
import * as Sentry from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

import TimeAgo from './util/timeago'
import './bootstrap'

Sentry.init({
  dsn: process.env.MIX_SENTRY_LARAVEL_DSN,
  integrations: [new BrowserTracing()],

  // Set tracesSampleRate to 1.0 to capture 100%
  // of transactions for performance monitoring.
  // We recommend adjusting this value in production
  tracesSampleRate: 1.0,
})

const locales = { id, en }

/**
 * @param {Date|Number} date
 * @param {String} fmt
 * @returns {String}
 */
window.dateFormat = (date, fmt) => {
  return format(date, fmt, { locale: locales[document.documentElement.lang] })
}

/**
 * @param {Number|BigInt} num
 * @returns {NUmber|String}
 */
window.numberFormat = (num) => {
  return new Intl.NumberFormat(document.documentElement.lang).format(num)
}

Alpine.plugin(TimeAgo.configure({ locale: locales[document.documentElement.lang] }))

Alpine.start()

const dataLayer = window.dataLayer || [];
const gtag = window.gtag = () => dataLayer.push(arguments)

window.addEventListener('DOMContentLoaded', () => {
  gtag('js', new Date())
  gtag('config', 'G-1KQP24LR0L')
})
