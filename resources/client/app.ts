import Alpine from 'alpinejs'
import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'

// import TimeAgo from './util/timeago'
import '~/bootstrap'

const locales: { [key in string]: Locale } = { id, en }
const locale = locales[document.documentElement.lang]

window.dateFormat = (date: Date, fmt: string) => {
  return format(date, fmt, { locale })
}

window.numberFormat = (num: number) => {
  return new Intl.NumberFormat(document.documentElement.lang).format(num)
}

// Alpine.plugin(TimeAgo.configure({ locale }))

Alpine.start()

// const dataLayer = window.dataLayer || []
// const gtag = window.gtag = (...args) => dataLayer.push(args)

// window.addEventListener('DOMContentLoaded', () => {
//   gtag('js', new Date())
//   gtag('config', 'G-1KQP24LR0L')
// })
