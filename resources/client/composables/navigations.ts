import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'
import type { MenuOption } from 'naive-ui'
import type { AppRoutes } from '~/modules/ziggy'

export type NavigationType = 'main' | 'user'

export interface NavigationItem {
  route?: keyof AppRoutes
  label: string
  icon: string
  children?: NavigationItem[]
}

interface NavigationOption {
  options: MenuOption[]
  updateCollapse: (collapsed: boolean) => void
  updateActiveKey: (key: string) => void
  updateExpandedKeys: (keys: string[]) => void
}

function transformMenu(parent?: MenuOption) {
  return (nav: NavigationItem) => {
    const key = nav.route?.replace(/\./g, '-') || nav.label.toLowerCase().replace(/\s/g, '-')
    const menu: MenuOption = {
      key: [parent?.key, key].filter(k => !!k).join('.'),
      icon: () => h(Icon, { icon: nav.icon }),
      active: nav.route ? route().current(nav.route) : false,
      label: () => {
        const children = { default: () => nav.label }

        return nav.route
          ? h(Link, { href: route(nav.route) }, children)
          : h('a', { href: '#' }, children)
      },
    }

    if (!menuPreference.value.activeKey && menu.active)
      menuPreference.value.activeKey = menu.key as string

    if (menuPreference.value.expandedKeys.length === 0 && menu.active && !!parent)
      menuPreference.value.expandedKeys = [parent.key as string]

    if (nav.children)
      menu.children = nav.children.map(transformMenu(menu))

    return menu
  }
}

export function useNavigation(type: NavigationType): NavigationOption {
  const options: MenuOption[] = __navigations[type].map(transformMenu())

  function updateCollapse(collapsed: boolean) {
    menuPreference.value.collapsed = collapsed
  }

  function updateActiveKey(key: string) {
    menuPreference.value.activeKey = key
  }

  function updateExpandedKeys(keys: string[]) {
    menuPreference.value.expandedKeys = keys
  }

  return { options, updateCollapse, updateActiveKey, updateExpandedKeys }
}
