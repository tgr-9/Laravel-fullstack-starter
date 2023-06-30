<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'
import { useNavigation } from '~/composables/navigations'

const { errors: _ } = defineProps<{
  errors: Object
}>()

const { locale, dateLocale, theme } = useNaiveConfig()

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const siderCollapsed = toRef(appPreference.value, 'siderCollapsed', false)
const logoWidth = computed(() => siderCollapsed.value ? 48 : undefined)
const { options, expandedKeys } = useNavigation('main')

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
        :collapsed="siderCollapsed"
        :on-update:collapsed="(collapsed) => siderCollapsed = collapsed"
        show-trigger
      >
        <header id="logo-wrapper">
          <transition>
            <main-logo
              :width="logoWidth"
              :initial="siderCollapsed"
              :rounded="siderCollapsed"
              :class="{ siderCollapsed }"
            />
          </transition>
        </header>

        <main id="main-navigation">
          <n-menu
            :options="options"
            :default-expanded-keys="expandedKeys"
            :collapsed-width="64"
            :collapsed-icon-size="22"
          />
        </main>
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
  @apply py-6;
}

#logo-wrapper {
  @apply h-14 px-6;

  &:has(.siderCollapsed) {
    @apply px-2;
  }
}
</style>
