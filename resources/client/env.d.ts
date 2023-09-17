/// <reference lib="DOM" />
/// <reference types="vite/client" />
/// <reference types="vue/ref-macros" />
/// <reference types="vite-plugin-pwa/client" />
/// <reference types="@intlify/unplugin-vue-i18n/messages" />

interface ImportMetaEnv {
  APP_ENV?: 'local' | 'testing' | 'staging' | 'production';
  APP_NAME?: string;
  APP_LOCALE?: AppLocale;
  APP_URL?: string;
  VITE_API_URL?: string;
  VITE_GTM_ID?: string;
  SENTRY_DSN?: string;
}

declare module '*.vue' {
  import type { DefineComponent } from 'vue'
  const component: DefineComponent<{}, {}, any>
  export default component
}
