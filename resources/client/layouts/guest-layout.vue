<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const { locale, dateLocale, theme } = useNaiveConfig()

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
  <n-config-provider :theme="theme" :locale="locale" :date-locale="dateLocale">
    <n-layout>
      <n-space vertical>
        <main-logo />

        <slot />
      </n-space>
    </n-layout>
  </n-config-provider>
</template>

<style lang="postcss">
/* #app {
  background-image: url(/app-bg.jpeg);
  background-position: top center;
  background-repeat: no-repeat;
  background-size: cover;
} */
</style>
