<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'

defineOptions({
  inheritAttrs: false,
})

const { title } = defineProps<{
  title?: string
}>()
</script>

<template>
  <i-head v-if="title" :title="$t(title)" />

  <app-wrapper class="guest-layout">
    <n-layout>
      <n-space vertical>
        <main-logo />

        <n-card>
          <slot />
        </n-card>
      </n-space>
    </n-layout>
  </app-wrapper>
</template>

<style lang="postcss">
.guest-layout {
  .n-layout {
    > & > &-scroll-container {
      @apply justify-center items-center;

      > .n-space {
        @apply w-sm;
      }
    }
  }

  .n-card {
    @apply blur-sm;

    & > &__content {
      @apply flex flex-col gap-4;
    }
  }

  .n-form {
    @apply flex flex-col gap-5 border-b border-b-gray-500 pb-6;

    .n-form-item {
      --n-feedback-height: auto !important;
    }
  }
}
</style>
