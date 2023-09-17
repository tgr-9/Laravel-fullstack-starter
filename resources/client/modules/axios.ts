import { captureException } from '@sentry/vue'
import axios from 'axios'
import type { AxiosError, AxiosStatic } from 'axios'

declare global {
  const axios: AxiosStatic

  interface Window {
    axios: AxiosStatic
  }
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $axios: AxiosStatic
  }
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true
axios.interceptors.response.use(response => response, (error: AxiosError) => {
  // whatever you want to do with the error
  captureException(error)
  logger(error)

  if (error.response?.status === 401) {
    window.location.replace('/login')
    return
  }

  throw error
})

if (import.meta.env.VITE_API_URL)
  axios.defaults.baseURL = import.meta.env.VITE_API_URL

export const install: AppModuleInstall = ({ app, isClient }): void => {
  if (!isClient)
    return

  app.config.globalProperties.$axios = window.axios = axios
}
