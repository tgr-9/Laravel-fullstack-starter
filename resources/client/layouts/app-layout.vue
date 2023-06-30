<script setup lang="ts">
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { errors: _ } = defineProps<{
  errors: Object
}>()

const { locale, dateLocale, theme } = useNaiveConfig()
const { options, updateCollapse, updateActiveKey, updateExpandedKeys } = useNavigation('main')

const { offlineReady } = useRegisterSW({
  immediate: true,
})

const logoWidth = computed(() => menuPreference.value.collapsed ? 48 : undefined)

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
  <n-config-provider :theme="theme" :locale="locale" :date-locale="dateLocale">
    <n-layout has-sider>
      <n-layout-sider
        bordered
        collapse-mode="width"
        :collapsed-width="64"
        :width="260"
        :collapsed="menuPreference.collapsed"
        :on-update:collapsed="updateCollapse"
        show-trigger
      >
        <header id="logo-wrapper">
          <transition>
            <main-logo
              :width="logoWidth"
              :initial="menuPreference.collapsed"
              :rounded="menuPreference.collapsed"
              :class="{ collapsed: menuPreference.collapsed }"
            />
          </transition>
        </header>

        <main id="main-navigation">
          <n-menu
            v-model:value="menuPreference.activeKey"
            v-model:expanded-keys="menuPreference.expandedKeys"
            :collapsed-icon-size="22"
            :collapsed-width="64"
            :on-update:expanded-keys="updateExpandedKeys"
            :on-update:value="updateActiveKey"
            :options="options"
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

  &:has(.collapsed) {
    @apply px-2;
  }
}
</style>
