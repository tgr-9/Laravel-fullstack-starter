import { Icon } from '@iconify/vue'
import { router } from '@inertiajs/vue3'
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
  expandedKeys?: string[]
}

function renderIcon(icon: string) {
  return () => h(Icon, { icon })
}

function generateRandomKey(length: number) {
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
  let result = ''
  for (let i = 0; i < length; i++)
    result += chars.charAt(Math.floor(Math.random() * chars.length))

  return result
}

function transformMenu(nav: NavigationItem): MenuOption {
  const menu: MenuOption = {
    key: nav.route?.replace(/\./g, '-') || generateRandomKey(10),
    label: () => h('div', { onClick: () => router.visit(nav.route!) }, { default: () => nav.label }),
    icon: renderIcon(nav.icon),
  }

  if (nav.children)
    menu.children = nav.children.map(transformMenu)

  return menu
}

export function useNavigation(type: NavigationType): NavigationOption {
  const options: MenuOption[] = __navigations[type].map(transformMenu)

  const expandedKeys = undefined

  return { options, expandedKeys }
}
