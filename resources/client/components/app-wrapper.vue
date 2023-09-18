<script setup lang="ts">
import { NDialogProvider, NMessageProvider, NNotificationProvider } from 'naive-ui'

const { locale, dateLocale, theme, themeOverrides } = useNaiveConfig()
</script>

<template>
  <n-config-provider
    :theme="theme"
    :theme-overrides="themeOverrides"
    :locale="locale"
    :date-locale="dateLocale"
    class="app-wrapper"
  >
    <n-message-provider :theme="theme?.Message" :theme-overrides="themeOverrides.Message">
      <n-notification-provider :theme="theme?.Notification" :theme-overrides="themeOverrides.Notification">
        <n-dialog-provider :theme="theme?.Dialog" :theme-overrides="themeOverrides.Dialog">
          <slot />
        </n-dialog-provider>
      </n-notification-provider>
    </n-message-provider>
  </n-config-provider>
</template>

<style lang="postcss">
.app-wrapper {
  .n-layout {
    > & > &-scroll-container {
      @apply min-h-screen flex;
    }
  }
}
</style>
