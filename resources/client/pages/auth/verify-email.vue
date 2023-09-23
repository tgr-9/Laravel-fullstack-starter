<script setup lang="ts">
defineOptions({
  layoutName: 'guest-layout',
})

function resend() {
  logger('sending request to', route('verification.send'))
}
</script>

<template>
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
