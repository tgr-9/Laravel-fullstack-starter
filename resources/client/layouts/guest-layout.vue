<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const { locale, dateLocale, theme, themeOverrides } = useNaiveConfig()

onMounted(async () => {
  const { registerSW } = await import('virtual:pwa-register')

  if (offlineReady.value)
    console.log('Offline ready', 'Your app is offline ready') // eslint-disable-line no-console

  registerSW({
    immediate: true,
  })
})
</script>

<template>
  <n-config-provider :theme="theme" :theme-overrides="themeOverrides" :locale="locale" :date-locale="dateLocale">
    <n-layout class="guest-layout">
      <n-space vertical>
        <main-logo />

        <slot />
      </n-space>
    </n-layout>
  </n-config-provider>
</template>

<style lang="postcss">
.guest-layout {
  .n-layout-scroll-container {
    @apply flex flex-col min-h-screen justify-center items-center;

    > .n-space {
      @apply w-sm;
    }
  }
}

.auth-bg {
  background-position: top center;
  background-repeat: no-repeat;
  background-size: cover;
  background-color: #dfe6f0;
}
</style>
