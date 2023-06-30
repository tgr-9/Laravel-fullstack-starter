<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'
import Layout from '~/layouts/guest-layout.vue'

defineOptions({
  layout: Layout,
})

const { errors: _ } = defineProps<{
  errors: Object
}>()

function resend() {
  console.log('sending request to', route('verification.send')) // eslint-disable-line no-console
}
</script>

<template>
  <i-head :title="$t('auth.routes.verify-email')" />

  <n-card :title="$t('auth.routes.verify-email')" size="medium" style="width: 450px; border-radius: 10px">
    <div class="mb-4 text-sm text-gray-600">
      {{ $t('auth.notices.verify-email') }}
    </div>

    <n-button
      type="primary"
      style="width: 100%;"
      @click="resend"
    >
      {{ $t('auth.actions.resend') }}
    </n-button>
  </n-card>
</template>
