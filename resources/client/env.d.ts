/// <reference types="vite/client" />

interface Window {
  dateFormat: (date: Date, fmt: string) => string
  numberFormat: (num: number) => string
  // extend the window
}

interface ImportMetaEnv {
  VITE_SENTRY_DSN?: string;
  VITE_SENTRY_TRACES_SAMPLE_RATE?: number;
  VITE_SENTRY_TRACE_QUEUE_ENABLED?: string;
  VITE_PUSHER_APP_KEY?: string;
  VITE_PUSHER_HOST?: string;
  VITE_PUSHER_PORT?: string;
  VITE_PUSHER_SCHEME?: string;
  VITE_PUSHER_APP_CLUSTER?: string;
}
