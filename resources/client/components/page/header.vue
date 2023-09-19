<script setup lang="ts">
import { Icon } from '@iconify/vue'

const { paths } = defineProps<{
  paths: string[]
}>()

const showPaths = paths.length > 0
</script>

<template>
  <header class="w-full bg-dark-800 border-b border-light-500 dark:border-dark-500">
    <div class="container md:mx-auto py-2">
      <n-breadcrumb v-if="showPaths">
        <n-breadcrumb-item>
          <icon icon="tabler:home" class="text-base inline-block m-0" />
        </n-breadcrumb-item>

        <n-breadcrumb-item v-for="path in paths" :key="path">
          {{ path }}
        </n-breadcrumb-item>
      </n-breadcrumb>

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
  }
}
</style>
