<script setup lang="ts">
import { Head as iHead } from '@inertiajs/vue3'
import type { NotificationType } from 'naive-ui'
import { useDialog, useNotification } from 'naive-ui'

const notification = useNotification()
const dialog = useDialog()

function notify(type: NotificationType) {
  notification[type]({
    content: 'Test',
  })
}

function confirm() {
  dialog.warning({
    title: 'Test Dialog',
    content: 'Are you sure?',
  })
}
</script>

<template>
  <i-head :title="$t('account.profile.page')" />

  <h3>Helps and Supports Goes Here</h3>

  <n-button @click="notify('error')">
    Notify
  </n-button>

  <n-button @click="confirm()">
    Confirm
  </n-button>
</template>
