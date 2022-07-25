export {}

import { Axios } from 'axios'

declare interface Window {
  dateFormat: (date: Date, fmt: string) => string
  numberFormat: (num: number) => string
  axios: Axios
  // extend the window
}
