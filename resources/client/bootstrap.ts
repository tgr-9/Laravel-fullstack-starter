import { captureException } from '@sentry/vue'
import axios from 'axios'
import type { AxiosError, AxiosStatic } from 'axios'
import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'

declare global {
  interface Window {
    dateFormat: (date: Date, fmt: string) => string
    numberFormat: (num: number) => string
    axios: AxiosStatic
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

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true
axios.interceptors.response.use(response => response, (error: AxiosError) => {
  // if (error.response?.status === 401)
  //   window.location.replace('/login')

  if (error.response?.status === 422)
    return error.response

  // whatever you want to do with the error
  captureException(error)
})

if (import.meta.env.VITE_API_URL)
  axios.defaults.baseURL = import.meta.env.VITE_API_URL

window.axios = axios

// const dataLayer = window.dataLayer || []
// const gtag = window.gtag = (...args) => dataLayer.push(args)

// gtag('js', new Date())
// gtag('config', 'G-1KQP24LR0L')
