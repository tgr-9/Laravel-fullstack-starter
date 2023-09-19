<script setup lang="ts">
const appName = import.meta.env.APP_NAME
</script>

<template>
  <footer class="w-full flex-grow-0 flex-shrink-0 bg-dark-800 border-t border-light-500 dark:border-dark-500">
    <div class="container py-2 md:mx-auto text-gray-500">
      {{ appName }}
    </div>
  </footer>
</template>
