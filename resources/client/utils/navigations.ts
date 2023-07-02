import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'
import type { DropdownOption, MenuOption } from 'naive-ui'
import type { AppRoutes } from '~/modules/ziggy'

export interface NavigationItem {
  label: string
  route?: keyof AppRoutes
  icon: string
  type?: 'divider' | 'group'
  disabled?: boolean
  children?: NavigationItem[]
}

interface Navigations {
  options: MenuOption[]
  updateCollapse: (collapsed: boolean) => void
  updateActiveKey: (key: string) => void
  updateExpandedKeys: (keys: string[]) => void
}

interface NavigationOptions {
  main: MenuOption
  user: DropdownOption
}

export type NavigationType = keyof NavigationOptions

function transformMenu(type: NavigationType, parent?: MenuOption) {
  return (nav: NavigationItem, i: number) => {
    if (nav.type === 'divider') {
      return {
        key: `${type}-devider-${i}`,
        type: 'divider',
      }
    }

    if (nav.type === 'group') {
      const group: MenuOption = {
        type: nav.type,
        key: nav.label.toLowerCase().replace(/\s/g, '-'),
        label: nav.label,
      }

      group.children = nav.children?.map(transformMenu(type, group))

      return group
    }

    const key = nav.route?.replace(/\./g, '-') || nav.label.toLowerCase().replace(/\s/g, '-')
    const menu: NavigationOptions[typeof type] = {
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
      menu.children = nav.children.map(transformMenu(type, menu))

    return menu
  }
}

export function useNavigation(type: NavigationType): Navigations {
  const options: MenuOption[] = __navigations[type].map(transformMenu(type))

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
