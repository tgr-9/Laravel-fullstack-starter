<script setup lang="ts">
defineOptions({
  inheritAttrs: false,
})
</script>

<template>
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
