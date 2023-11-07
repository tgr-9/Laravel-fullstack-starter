<script setup lang="ts">
const { title, horizontal } = defineProps<{
  title: string
  horizontal?: boolean
}>()
</script>

<template>
  <section class="flex flex-col md:flex-row">
    <h3 class="w-full md:w-1/6 font-bold text-lg" v-html="title" />

    <div
      class="w-full md:w-5/6 flex gap-4 items-start"
      :class="[
        horizontal ? 'flex-col md:flex-row' : 'flex-col',
      ]"
    >
      <slot />
    </div>
  </section>
</template>
