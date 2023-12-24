<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { Head as iHead } from '@inertiajs/vue3'
import { breakpointsTailwind } from '@vueuse/core'
import { NDropdown, NLayoutSider, NMenu } from 'naive-ui'
import type { MenuInst } from 'naive-ui'
import type { Message, User } from '~/types/app'
import type { BreadcrumbItem } from '~/utils/navigations'

defineOptions({
  inheritAttrs: false,
})

const props = defineProps<{
  page: string
  paths: string[]
  title?: string
  message?: Message | null
  user: User
  errors?: Record<string, string> | null
}>()

const { t } = useI18n()

const mainMenu = ref<InstanceType<typeof NMenu> | MenuInst | null>(null)
const userMenu = ref<InstanceType<typeof NDropdown> | null>(null)
const sider = ref<InstanceType<typeof NLayoutSider> | null>(null)

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

const pageTitle = computed(() => props.title || t(props.page))
const siderCollapsed = computed(() => appNavigation.value.collapsed || (onMediumScreen.value && !onSmallScreen.value))
const siderPosition = computed(() => onSmallScreen.value ? 'absolute' : 'static')
const siderCollapsedMode = computed(() => onSmallScreen.value ? 'transform' : 'width')
const siderCollapsedWidth = computed(() => onSmallScreen.value ? 0 : 64)
const logoWidth = computed(() => siderCollapsed.value ? 48 : undefined)
const touches = reactive({ x: 0, y: 0 })
const paths = computed(() => {
  const items = props.paths.reduce((paths, item) => {
    paths.push({
      label: t(item),
    })

    return paths
  }, [] as BreadcrumbItem[])

  items.push({
    label: pageTitle.value,
  })

  return items
})

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
  <i-head :title="pageTitle" />

  <app-wrapper class="app-layout">
    <n-layout has-sider class="transition-all" @touchstart.passive="touchStart" @touchend.passive="touchEnd">
      <n-layout-sider
        ref="sider"
        bordered
        :collapse-mode="siderCollapsedMode"
        :collapsed-width="siderCollapsedWidth"
        :collapsed="siderCollapsed"
        :on-update:collapsed="updateCollapse"
        :position="siderPosition"
        :show-trigger="!onMediumScreen"
        class="z-10 transition-all"
      >
        <header id="logo-wrapper" class="n-layout-sider-section w-full py-3">
          <transition>
            <main-logo
              :width="logoWidth"
              :initial="siderCollapsed"
              :rounded="siderCollapsed"
              :class="{ collapsed: siderCollapsed }"
            />
          </transition>
        </header>

        <main id="main-navigation" class="n-layout-sider-section w-full flex-grow py-2">
          <n-menu
            ref="mainMenu"
            v-model:value="appNavigation.activeKey"
            v-model:expanded-keys="appNavigation.expandedKeys"
            :collapsed-icon-size="22"
            :collapsed-width="64"
            :on-update:expanded-keys="updateMainExpandedKeys"
            :on-update:value="updateMainActiveKey"
            :options="menuOptions"
            :root-indent="24"
          />
        </main>

        <footer id="user-navigation" class="n-layout-sider-section w-full p-3 flex-grow-0 flex-shrink-0">
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
                {{ props.user.name }}
              </p>
            </n-button>
          </n-dropdown>
        </footer>
      </n-layout-sider>

      <n-layout-content>
        <page-header :paths="paths" class="page-content-section">
          <h1 class="text-3xl font-bold" v-html="pageTitle" />
        </page-header>

        <page-main class="page-content-section">
          <n-alert
            v-if="props.message"
            :title="props.message.title"
            :type="props.message.type"
          />

          <slot />
        </page-main>

        <page-footer class="page-content-section" />
      </n-layout-content>
    </n-layout>
  </app-wrapper>
</template>

<style lang="postcss">
.page-content-section {
  @apply px-4;
}

#logo-wrapper {
  @apply px-6 flex items-center justify-center;

  &:has(.collapsed) {
    @apply px-2;
  }
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
