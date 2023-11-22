import '@inertiajs/core'

export type Locale = 'id' | 'en'

export interface Message {
  type?: 'warning' | 'error' | 'info' | 'success'
  title: string
  description: string
}

export interface User {
  name: string
  email: string
}

declare module '@inertiajs/core' {
  export interface PageProps {
    user: User | null
    message: Message | null
  }
}
