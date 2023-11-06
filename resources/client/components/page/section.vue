<script setup lang="ts">
const { title } = defineProps<{
  title: string
}>()
</script>

<template>
  <section class="flex flex-col md:flex-row">
    <h3 class="w-full md:w-1/6 font-bold text-lg" v-html="title" />

    <div class="w-full md:w-5/6 flex flex-col gap-4">
      <slot />
    </div>
  </section>
</template>
