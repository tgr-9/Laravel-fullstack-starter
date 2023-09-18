<script setup lang="ts">
defineOptions({
  pageName: 'auth.routes.verify-email',
  layoutName: 'guest-layout',
})

function resend() {
  console.log('sending request to', route('verification.send')) // eslint-disable-line no-console
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
