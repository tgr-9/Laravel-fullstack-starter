import { router } from '@inertiajs/core'
import { captureException, setExtras } from '@sentry/vue'
import axios from 'axios'
import type { AxiosError, AxiosResponse, AxiosStatic } from 'axios'

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.interceptors.response.use(response => response, (error: AxiosError) => {
  const response = error.response as AxiosResponse

  if (response.status === 401) {
    router.visit(route('login'))
    return
  }

  if (response.status === 419) {
    useNaiveDiscreteApi().notification.error({
      title: 'Page expired',
    })

    router.reload()
    return
  }

  // Capture error response data to sentry
  setExtras({
    payload: JSON.parse(error.config?.data ?? '{}'),
  })

  captureException(
    error.config?.headers.has('X-Inertia') ? error : response.data,
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
