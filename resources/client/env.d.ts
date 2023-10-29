/// <reference lib="DOM" />

interface ImportMetaEnv {
  APP_ENV?: 'local' | 'testing' | 'staging' | 'production';
  APP_NAME?: string;
  APP_LOCALE?: AppLocale;
  APP_URL?: string;
  VITE_API_URL?: string;
  VITE_GTM_ID?: string;
  SENTRY_DSN?: string;
  SENTRY_PROFILING_ENABLE?: boolean;
}

declare module '*.vue' {
  import type { DefineComponent } from 'vue'
  const component: DefineComponent<{}, {}, any>
  export default component
}
