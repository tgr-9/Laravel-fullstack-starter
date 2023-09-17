import type { PageProps, Page } from '@inertiajs/core'

export {}

interface AppPageProps extends PageProps {
  user?: UserProp
  flash: FlashProp
}

interface FlashProp {
  success?: boolean
  errors: array
}

interface UserProp {
  name: string
  email: string
}

declare module '@inertiajs/vue3' {
  export function usePage<T extends AppPageProps>(): Page<T>
}
