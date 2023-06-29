<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'
</script>

<template>
  <i-head title="Dashboard" />

  <h3>{{ $t('dashboard.welcome-notice', { user: 'John Doe' }) }}</h3>

  <a :href="$route('home')">
    Home
  </a>
</template>
