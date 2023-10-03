import { format } from 'date-fns'
import { enUS as en, id } from 'date-fns/locale'

export const install: AppModuleInstall = ({ isClient }): void => {
  if (!isClient)
    return

  const locales: { [key in string]: Locale } = { id, en }

  window.dateFormat = (date: Date, fmt: string) => {
    return format(date, fmt, {
      locale: locales[document.documentElement.lang],
    })
  }

  window.numberFormat = (num: number) => {
    return new Intl.NumberFormat(document.documentElement.lang).format(num)
  }
}

declare global {
  const dateFormat: (date: Date, fmt: string) => string
  const numberFormat: (num: number) => string

  interface Window {
    dateFormat: typeof dateFormat
    numberFormat: typeof numberFormat
  }
}
