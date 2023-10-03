<script setup lang="ts">
import type { NotificationType } from 'naive-ui'

defineOptions({
  pageName: 'account.settings.page',
})

const { notification } = useNaiveDiscreteApi()

function notify(type: NotificationType) {
  notification[type]({
    content: 'Test',
  })
}
</script>

<template>
  <h3>Helps and Supports Goes Here</h3>

  <n-button @click="$message.info('test')">
    Notify 1
  </n-button>

  <n-button @click="notify('error')">
    Notify 2
  </n-button>
</template>
