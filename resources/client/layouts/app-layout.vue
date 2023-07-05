<script setup lang="ts">
import { Icon } from '@iconify/vue'
import type { MenuInst } from 'naive-ui'

defineOptions({
  inheritAttrs: false,
})

const mainMenu = ref<MenuInst | null>(null)
const userMenu = ref<VNode | null>(null)

const {
  options: menuOptions,
  updateCollapse,
  updateActiveKey: updateMainActiveKey,
  updateExpandedKeys: updateMainExpandedKeys,
} = useNavigation('main')

const {
  options: userOptions,
  updateActiveKey: updateUserActiveKey,
} = useNavigation('user')

const logoWidth = computed(() => menuPreference.value.collapsed ? 48 : undefined)
</script>

<template>
  <app-wrapper class="app-layout">
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
            ref="mainMenu"
            v-model:value="menuPreference.activeKey"
            v-model:expanded-keys="menuPreference.expandedKeys"
            :collapsed-icon-size="22"
            :collapsed-width="64"
            :on-update:expanded-keys="updateMainExpandedKeys"
            :on-update:value="updateMainActiveKey"
            :options="menuOptions"
            :root-indent="24"
          />
        </main>

        <footer id="user-navigation" class="n-layout-sider-section px-2 flex-grow-0 flex-shrink-0">
          <n-dropdown
            ref="userMenu"
            trigger="click"
            :options="userOptions"
            :on-select="updateUserActiveKey"
          >
            <n-button
              block
              :bordered="false"
              class="py-1 h-auto"
              :class="{ collapsed: menuPreference.collapsed }"
            >
              <div class="w-full flex flex-grow gap-4 items-center justify-center">
                <n-avatar class="flex-none">
                  <icon icon="tabler:user" />
                </n-avatar>

                <transition>
                  <p v-if="!menuPreference.collapsed" class="text-left truncate font-bold">
                    User Name Goes Here with very long name
                  </p>
                </transition>
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
  </app-wrapper>
</template>

<style lang="postcss">
.app-layout {
  .n-layout {
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

#user-navigation {
  .n-button.collapsed {
    @apply px-1;
  }
}

#logo-wrapper {
  @apply h-14 px-6;

  &:has(.collapsed) {
    @apply px-2;
  }
}
</style>
