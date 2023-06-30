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
      <n-space>
        <slot />
      </n-space>
    </n-layout>
  </n-config-provider>
</template>

<style lang="postcss">
.n-layout {
  @apply pt-6 sm:pt-0;

  &, & > &-scroll-container {
    @apply min-h-screen;
  }

  & > &-scroll-container {
    @apply  flex flex-col sm:justify-center items-center;
  }
}
</style>
