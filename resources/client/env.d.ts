/// <reference lib="DOM" />
/// <reference types="vite/client" />
/// <reference types="vue/ref-macros" />
/// <reference types="vite-plugin-pwa/client" />
/// <reference types="@intlify/unplugin-vue-i18n/messages" />

interface ImportMetaEnv {
  APP_NAME?: string;
  APP_LOCALE?: 'id' | 'en';
  APP_URL?: string;
  VITE_API_URL?: string;
  VITE_SENTRY_DSN?: string;
  VITE_SENTRY_TRACES_SAMPLE_RATE?: number;
  VITE_SENTRY_TRACE_QUEUE_ENABLED?: string;
  // VITE_PUSHER_APP_KEY?: string;
  // VITE_PUSHER_HOST?: string;
  // VITE_PUSHER_PORT?: string;
  // VITE_PUSHER_SCHEME?: string;
  // VITE_PUSHER_APP_CLUSTER?: string;
}

declare module '*.vue' {
  import type { DefineComponent } from 'vue'
  const component: DefineComponent<{}, {}, any>
  export default component
}
