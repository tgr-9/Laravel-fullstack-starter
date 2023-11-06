<script setup lang="ts">
const appName = import.meta.env.APP_NAME
</script>

<template>
  <footer class="w-full flex-grow-0 flex-shrink-0 dark:bg-dark-800 border-t light:border-light-300 dark:border-dark-200">
    <div class="container py-2 md:mx-auto dark:text-gray-500">
      {{ appName }}
    </div>
  </footer>
</template>
