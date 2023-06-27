<script setup lang="ts">
</script>

<template>
  <n-space vertical size="large">
    <n-layout has-sider>
      <n-layout-sider
        bordered
        collapse-mode="width"
        :collapsed-width="64"
        :width="260"
        show-trigger
      >
        <main-logo width="150" />
      </n-layout-sider>

      <n-layout-content content-style="padding: 12px">
        <slot />
      </n-layout-content>
    </n-layout>
  </n-space>
</template>

<style lang="postcss">
.n-space {
  @apply min-h-full;
}
.n-menu {
  height: 680px;
}
.n-layout-sider {
  @apply min-h-full;
  padding-top: 30px;
}
</style>
