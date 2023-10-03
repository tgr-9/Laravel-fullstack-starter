<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'

defineOptions({
  pageName: 'dashboard.routes.index',
})

const { props } = usePage()
const user = props.user?.name
</script>

<template>
  <h3>{{ $t('dashboard.welcome-notice', { user }) }}</h3>

  <a :href="$route('home')">
    Home
  </a>
</template>
