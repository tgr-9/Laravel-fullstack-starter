import type { AxiosError, AxiosStatic } from 'axios'
import axios from 'axios'
import { captureException } from '@sentry/browser'

declare global {
  interface Window {
    axios: AxiosStatic
  }
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
