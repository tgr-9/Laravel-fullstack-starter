import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'

declare global {
  const dateFormat: (date: Date, fmt: string) => string
  const numberFormat: (num: number) => string

  interface Window {
    dateFormat: typeof dateFormat
    numberFormat: typeof numberFormat
  }
}

const locales: { [key in string]: Locale } = { id, en }

window.dateFormat = (date: Date, fmt: string) => {
  return format(date, fmt, {
    locale: locales[document.documentElement.lang],
  })
}

window.numberFormat = (num: number) => {
  return new Intl.NumberFormat(document.documentElement.lang).format(num)
}

// const dataLayer = window.dataLayer || []
// const gtag = window.gtag = (...args) => dataLayer.push(args)

// gtag('js', new Date())
// gtag('config', 'G-1KQP24LR0L')
