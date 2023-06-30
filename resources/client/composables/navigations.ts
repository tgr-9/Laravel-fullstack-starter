import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'
import type { MenuOption } from 'naive-ui'
import type { AppRoutes } from '~/modules/ziggy'

export type NavigationType = 'main' | 'user'

export interface NavigationItem {
  label: string
  route?: keyof AppRoutes
  icon: string
  type?: 'devider' | 'group'
  disabled?: boolean
  children?: NavigationItem[]
}

interface NavigationOption {
  options: MenuOption[]
  updateCollapse: (collapsed: boolean) => void
  updateActiveKey: (key: string) => void
  updateExpandedKeys: (keys: string[]) => void
}

function transformMenu(parent?: MenuOption) {
  return (nav: NavigationItem, i: number) => {
    if (nav.type === 'devider') {
      return {
        type: 'devider',
        key: `devider-${i}`,
        props: {
          style: {},
        },
      }
    }

    if (nav.type === 'group') {
      const group: MenuOption = {
        type: nav.type,
        key: nav.label.toLowerCase().replace(/\s/g, '-'),
        label: nav.label,
      }

      group.children = nav.children?.map(transformMenu(group))

      return group
    }

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
  const options: MenuOption[] = __navigations[type]
    .filter(nav => nav.type !== 'devider')
    .map(transformMenu())

  logger(options)
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
