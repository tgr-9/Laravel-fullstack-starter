<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const { locale, dateLocale, theme, themeOverrides } = useNaiveConfig()

onMounted(async () => {
  const { registerSW } = await import('virtual:pwa-register')

  if (offlineReady.value)
    logger('Offline ready', 'Your app is offline ready')

  registerSW({
    immediate: true,
  })
})
</script>

<template>
  <n-config-provider
    :theme="theme"
    :theme-overrides="themeOverrides"
    :locale="locale"
    :date-locale="dateLocale"
    class="app-wrapper"
  >
    <slot />
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
