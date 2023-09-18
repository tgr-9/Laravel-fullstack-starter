<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'
import type { NotificationType } from 'naive-ui'

const { notification } = useNaiveDiscreteApi()

function notify(type: NotificationType) {
  notification[type]({
    content: 'Test',
  })
}
</script>

<template>
  <i-head :title="$t('account.profile.page')" />

  <h3>Helps and Supports Goes Here</h3>

  <n-button @click="$message.info('test')">
    Notify 1
  </n-button>

  <n-button @click="notify('error')">
    Notify 2
  </n-button>
</template>
