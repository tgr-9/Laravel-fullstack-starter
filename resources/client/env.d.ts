/// <reference types="vite/client" />

interface ImportMetaEnv {
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
