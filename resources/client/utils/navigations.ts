import { Icon } from '@iconify/vue'
import { Link, router } from '@inertiajs/vue3'
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

/**
 * Navigation configurations.
 */
interface Navigations {
  /**
   * Navigation option
   */
  options: MenuOption[]
  /**
   * Update navigation collapse state
   * @param collapsed Collapse state
   */
  updateCollapse: (collapsed: boolean) => void
  /**
   * Update navigation active state by key
   * @param key Navigation key
   */
  updateActiveKey: (key: string) => void
  /**
   * Update navigation expanded state by keys
   * @param keys Navigation keys
   */
  updateExpandedKeys: (keys: string[]) => void
}

interface NavigationOptions {
  main: MenuOption
  user: DropdownOption
}

export type NavigationType = keyof NavigationOptions

/**
 * Transform navigation structure.
 *
 * Either `MenuOption` and `DropdownOption` shares similar structure.
 *
 * @see https://www.naiveui.com/en-US/os-theme/components/menu
 * @see https://www.naiveui.com/en-US/os-theme/components/dropdown
 * @param type Navigation type
 * @param parent Parent navigation, default `undefined` which is for root item
 * @returns Navigation options, it could be `MenuOption` or `DropdownOption` depending the `type`
 */
function transformMenu(type: NavigationType, parent?: MenuOption) {
  return (nav: NavigationItem, i: number) => {
    if (nav.type === 'divider') {
      return {
        key: `${type}-divider-${i}`,
        type: 'divider',
      }
    }

    if (nav.type === 'group') {
      const group: NavigationOptions[typeof type] = {
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

        if (!nav.route)
          return h('a', { href: '#' }, children)

        const href = route(nav.route)

        if (nav.route !== 'logout')
          h(Link, { href }, children)

        return h('a', {
          href,
          onClick: (e: Event) => {
            router.post(href)

            e.preventDefault()
          },
        }, children)
      },
    }

    if (!menuPreference.value.activeKey && menu.active)
      updateActiveKey(menu.key as string)

    if (menuPreference.value.expandedKeys.length === 0 && menu.active && !!parent)
      updateExpandedKeys([parent.key as string])

    if (nav.children)
      menu.children = nav.children.map(transformMenu(type, menu))

    return menu
  }
}

function updateCollapse(collapsed: boolean) {
  menuPreference.value.collapsed = collapsed
}

function updateActiveKey(key?: string) {
  menuPreference.value.activeKey = key
}

function updateExpandedKeys(keys: string[]) {
  menuPreference.value.expandedKeys = keys
}

/**
 * Use navigation configuration
 *
 * @param type Navigation type, which is : `user` and `main`
 * @returns Navigation configurations
 */
export function useNavigation(type: NavigationType): Navigations {
  if (menuPreference.value.activeKey === 'logout') {
    updateActiveKey()
    updateExpandedKeys([])
  }

  const options: MenuOption[] = __navigations[type].map(transformMenu(type))

  return { options, updateCollapse, updateActiveKey, updateExpandedKeys }
}
