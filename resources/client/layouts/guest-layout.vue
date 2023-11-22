<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'
import type { Message, User } from '~/types/app'

defineOptions({
  inheritAttrs: false,
})

const props = defineProps<{
  page: string
  paths: string[]
  title?: string
  message?: Message | null
  user?: User | null
  errors?: Record<string, string> | null
}>()

const { t } = useI18n()
const pageTitle = computed(() => props.title || t(props.page))
</script>

<template>
  <i-head :title="pageTitle" />

  <app-wrapper class="guest-layout">
    <n-layout>
      <n-space vertical>
        <main-logo />

        <n-card :title="pageTitle">
          <n-alert
            v-if="props.message"
            :title="props.message.title"
            :type="props.message.type"
          />

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
    @apply flex flex-col gap-5 border-b light:border-light-500 dark:border-gray-500 pb-6;

    .n-form-item {
      --n-feedback-height: auto !important;
    }
  }
}
</style>
