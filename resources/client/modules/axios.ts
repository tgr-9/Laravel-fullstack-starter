import { captureException, setExtras } from '@sentry/vue'
import axios from 'axios'
import type { AxiosError, AxiosStatic } from 'axios'

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.interceptors.response.use(response => response, (error: AxiosError) => {
  if (!error.response) {
    captureException(error)

    throw error
  }

  if (error.response.status === 401) {
    location.replace(route('login'))
    return
  }

  if (error.response.status === 419) {
    location.reload()
    return
  }

  // Capture error response data to sentry
  setExtras({
    payload: JSON.parse(error.config?.data ?? '{}'),
  })

  captureException(
    error.config?.headers.has('X-Inertia') ? error : error.response.data,
  )

  throw error
})

if (import.meta.env.VITE_API_URL)
  axios.defaults.baseURL = import.meta.env.VITE_API_URL

export const install: AppModuleInstall = ({ app, isClient }): void => {
  if (!isClient)
    return

  app.config.globalProperties.$axios = window.axios = axios
}

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
