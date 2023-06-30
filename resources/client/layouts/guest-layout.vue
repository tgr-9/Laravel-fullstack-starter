<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { offlineReady } = useRegisterSW({
  immediate: true,
})

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
  <n-space vertical size="large">
    <n-layout>
      <n-layout-content content-style="padding: 12px">
        <slot />
      </n-layout-content>
    </n-layout>
  </n-space>
</template>

<style lang="postcss">
/*  */
</style>
