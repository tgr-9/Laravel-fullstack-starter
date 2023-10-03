<script setup lang="ts">
const { locale, dateLocale, theme, themeOverrides } = useNaiveConfig()
</script>

<template>
  <n-config-provider
    :theme="theme"
    :theme-overrides="themeOverrides"
    :locale="locale"
    :date-locale="dateLocale"
    class="app-wrapper"
  >
    <slot />
  </n-config-provider>
</template>

<style lang="postcss">
.n-layout {
  &, &-sider {
    & > &-scroll-container {
      @apply min-h-screen flex flex-col;
    }
  }
}
</style>
