<script setup lang="ts">
import type { NotificationType } from 'naive-ui'

defineOptions({
  pageName: 'sample.routes.index',
})

const { notification } = useNaiveDiscreteApi()

function notify(type: NotificationType) {
  notification[type]({
    content: 'Test',
  })
}
</script>

<template>
  <div class="flex gap-4 w-full flex-col">
    <page-section title="Message">
      <n-button @click="$message.info('test')">
        Show Message
      </n-button>
    </page-section>

    <page-section title="Notification">
      <n-button @click="notify('error')">
        Show Notification
      </n-button>
    </page-section>
  </div>
</template>
