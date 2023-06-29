<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { errors: _ } = defineProps<{
  errors: Object
}>()

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
    <n-layout has-sider>
      <n-layout-sider
        bordered
        collapse-mode="width"
        :collapsed-width="64"
        :width="260"
        show-trigger
      >
        <main-logo width="150" />
      </n-layout-sider>

      <n-layout-content content-style="padding: 12px">
        <slot />
      </n-layout-content>
    </n-layout>
  </n-space>
</template>

<style lang="postcss">
.n-space {
  @apply min-h-full;
}
.n-menu {
  height: 680px;
}
.n-layout-sider {
  @apply min-h-full;
  padding-top: 30px;
}
</style>
