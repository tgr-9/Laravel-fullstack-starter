<script setup lang="ts">
import { Icon } from '@iconify/vue'
import type { BreadcrumbItem } from '~/utils/navigations'

const props = defineProps<{
  paths: BreadcrumbItem[]
}>()

const paths = computed(() => props.paths.map((path) => {
  path.clickable = 'href' in path
  return path
}))
</script>

<template>
  <header class="w-full">
    <n-breadcrumb
      v-if="paths.length > 0"
      class="container md:mx-auto py-3 border-b light:border-light-500 dark:border-dark-200"
    >
      <n-breadcrumb-item :href="$route('home')">
        <icon icon="tabler:home" class="text-base inline-block m-0" />
      </n-breadcrumb-item>

      <n-breadcrumb-item
        v-for="(path, i) in paths" :key="i"
        :clickable="path.clickable"
        :href="path.href"
      >
        <icon v-if="path.icon" :icon="path.icon" class="text-base inline-block m-0" />{{ path.label }}
      </n-breadcrumb-item>
    </n-breadcrumb>

    <div class="container md:mx-auto pt-6 pb-2">
      <slot />
    </div>
  </header>
</template>

<style lang="postcss">
.n-breadcrumb {
  > ul {
    @apply inline-flex;
  }

  & &-item {
    @apply items-center;

    &__link {
      color: red;
    }
  }
}
</style>
