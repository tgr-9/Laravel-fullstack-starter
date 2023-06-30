<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { errors: _ } = defineProps<{
  errors: Object
}>()

const { locale, dateLocale, theme } = useNaiveConfig()

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const initial = ref<boolean>(false)
const logoWidth = computed(() => initial.value ? 48 : undefined)

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
    <n-layout has-sider>
      <n-layout-sider
        bordered
        collapse-mode="width"
        :collapsed-width="64"
        :width="260"
        :on-update:collapsed="(collapsed) => initial = collapsed"
        show-trigger
      >
        <transition>
          <main-logo :width="logoWidth" :initial="initial" :rounded="initial" :class="{ initial }" />
        </transition>
      </n-layout-sider>

      <n-layout-content>
        <n-space vertical size="large">
          <slot />
        </n-space>
      </n-layout-content>
    </n-layout>
  </n-config-provider>
</template>

<style lang="postcss">
.n-layout-sider {
  @apply p-6;

  &:has(.initial) {
    @apply py-6 px-2;
  }
}
</style>
