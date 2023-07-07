<script setup lang="ts">
import { Head as iHead, usePage } from '@inertiajs/vue3'

const { props } = usePage()
</script>

<template>
  <i-head :title="$t('dashboard.routes.index')" />

  <h3>{{ $t('dashboard.welcome-notice', { user: props.user?.name }) }}</h3>

  <a :href="$route('home')">
    Home
  </a>
</template>
