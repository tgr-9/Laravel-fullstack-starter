<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useRegisterSW } from 'virtual:pwa-register/vue'

const { errors: _ } = defineProps<{
  errors: Object
}>()

const { locale, dateLocale, theme, themeOverrides } = useNaiveConfig()

const {
  options: menuOptions,
  updateCollapse,
  updateActiveKey,
  updateExpandedKeys,
} = useNavigation('main')

const {
  options: userOptions,
} = useNavigation('user')

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
  <n-config-provider :theme="theme" :theme-overrides="themeOverrides" :locale="locale" :date-locale="dateLocale">
    <n-layout has-sider class="app-layout">
      <n-layout-sider
        bordered
        collapse-mode="width"
        :collapsed-width="64"
        :width="260"
        :collapsed="menuPreference.collapsed"
        :on-update:collapsed="updateCollapse"
        show-trigger
      >
        <header id="logo-wrapper" class="n-layout-sider-section">
          <transition>
            <main-logo
              :width="logoWidth"
              :initial="menuPreference.collapsed"
              :rounded="menuPreference.collapsed"
              :class="{ collapsed: menuPreference.collapsed }"
            />
          </transition>
        </header>

        <main id="main-navigation" class="n-layout-sider-section flex-grow">
          <n-menu
            v-model:value="menuPreference.activeKey"
            v-model:expanded-keys="menuPreference.expandedKeys"
            :collapsed-icon-size="22"
            :collapsed-width="64"
            :on-update:expanded-keys="updateExpandedKeys"
            :on-update:value="updateActiveKey"
            :options="menuOptions"
            :root-indent="24"
          />
        </main>

        <footer class="n-layout-sider-section px-2 flex-grow-0 flex-shrink-0">
          <n-dropdown trigger="click" :options="userOptions">
            <n-button block :bordered="false" class="py-1 h-auto">
              <div class="w-full flex flex-grow gap-4 items-center justify-center">
                <n-avatar class="flex-none">
                  <icon icon="tabler:user" />
                </n-avatar>

                <p class="text-left truncate font-bold">
                  User Name Goes Here with very long name
                </p>
              </div>
            </n-button>
          </n-dropdown>
        </footer>
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
.app-layout {
  .n-layout {
    &-scroll-container {
      @apply min-h-screen;
    }

    &-sider {
      & > &-scroll-container {
        @apply flex flex-col py-6;
      }

      & > &-section {
        @apply w-full;
      }
    }

    &-content > &-scroll-container {
      @apply py-6 px-2 sm:px-6;
    }
  }
}

#logo-wrapper {
  @apply h-14 px-6;

  &:has(.collapsed) {
    @apply px-2;
  }
}
</style>
