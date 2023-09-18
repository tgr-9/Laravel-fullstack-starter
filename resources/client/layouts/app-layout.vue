<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { Head as iHead, usePage } from '@inertiajs/vue3'
import type { MaybeElement } from '@vueuse/core'
import { breakpointsTailwind } from '@vueuse/core'
import type { MenuInst } from 'naive-ui'

defineOptions({
  inheritAttrs: false,
})

const { title } = defineProps<{
  title?: string
}>()

const mainMenu = ref<MenuInst | null>(null)
const userMenu = ref<VNode | null>(null)
const sider = ref<MaybeElement | null>(null)

const { props } = usePage()
const breakpoints = useBreakpoints(breakpointsTailwind)
const onSmallScreen = breakpoints.smallerOrEqual('sm')
const onMediumScreen = breakpoints.smallerOrEqual('md')

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

const siderCollapsed = computed(() => menuPreference.value.collapsed || (onMediumScreen.value && !onSmallScreen.value))
const siderPosition = computed(() => onSmallScreen.value ? 'absolute' : 'static')
const siderCollapsedMode = computed(() => onSmallScreen.value ? 'transform' : 'width')
const siderCollapsedWidth = computed(() => onSmallScreen.value ? 0 : 64)
const logoWidth = computed(() => siderCollapsed.value ? 48 : undefined)
const touches = reactive({ x: 0, y: 0 })

onClickOutside(sider, () => {
  if (onSmallScreen.value)
    updateCollapse(!siderCollapsed.value)
})

function touchStart(e: TouchEvent) {
  touches.x = e.touches[0].clientX
  touches.y = e.touches[0].clientY
}

function touchEnd(e: TouchEvent) {
  const changed = e.changedTouches[0]

  updateCollapse(siderCollapsed
    ? changed.clientX <= (touches.x - 10)
    : changed.clientX >= (touches.x + 10))

  touches.x = 0
  touches.y = 0
}
</script>

<template>
  <i-head v-if="title" :title="$t(title)" />

  <app-wrapper class="app-layout">
    <n-layout has-sider @touchstart="touchStart" @touchend="touchEnd">
      <n-layout-sider
        ref="sider"
        bordered
        :collapse-mode="siderCollapsedMode"
        :collapsed-width="siderCollapsedWidth"
        :collapsed="siderCollapsed"
        :on-update:collapsed="updateCollapse"
        :position="siderPosition"
        :show-trigger="!onMediumScreen"
      >
        <header id="logo-wrapper" class="n-layout-sider-section">
          <transition>
            <main-logo
              :width="logoWidth"
              :initial="siderCollapsed"
              :rounded="siderCollapsed"
              :class="{ collapsed: siderCollapsed }"
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
              :class="{ collapsed: siderCollapsed }"
            >
              <n-avatar>
                <icon icon="tabler:user" />
              </n-avatar>

              <p id="user-menu-label">
                {{ props.user?.name }}
              </p>
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
    @apply transition-all;

    &-sider {
      @apply z-10 transition-all;

      & > &-scroll-container {
        @apply flex flex-col min-h-screen py-3;
      }

      & > &-section {
        @apply w-full;
      }
    }
  }
}

#logo-wrapper {
  @apply h-14 px-6 flex items-center justify-center;

  &:has(.collapsed) {
    @apply px-2;
  }
}

#main-navigation {
  @apply py-2;
}

#user-navigation {
  .n-button {
    @apply py-2 px-3 h-auto transition-all text-base;

    &__content {
      @apply w-full flex flex-grow gap-4 items-center justify-center;
    }

    .n-avatar {
      @apply flex-none;
    }

    #user-menu-label {
      @apply w-full text-left truncate font-bold leading-none;
    }

    &.collapsed {
      @apply p-0;

      .n-avatar {
        @apply h-11 w-11;
      }

      #user-menu-label {
        @apply hidden;
      }
    }
  }
}
</style>
