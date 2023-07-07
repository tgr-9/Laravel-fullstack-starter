<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

function resend() {
  console.log('sending request to', route('verification.send')) // eslint-disable-line no-console
}
</script>

<template>
  <i-head :title="$t('auth.routes.verify-email')" />

  <n-alert :title="$t('auth.routes.verify-email')" type="info">
    {{ $t('auth.notices.verify-email') }}
  </n-alert>

  <n-button
    type="primary"
    style="width: 100%;"
    @click="resend"
  >
    {{ $t('auth.actions.resend') }}
  </n-button>
</template>
