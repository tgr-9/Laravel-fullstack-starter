<script setup lang="ts">
import type { NotificationType } from 'naive-ui'

defineOptions({
  pageName: 'sample.routes.index',
})

const { message, notification } = useNaiveDiscreteApi()

function notify(type: NotificationType) {
  notification[type]({
    content: 'Test',
  })
}

async function notifyFirebase() {
  try {
    const { data } = await axios.post(route('sample.firebase'))

    logger(data)
  }
  catch (e) {
    message.warning('Could not sent notification')
  }
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

    <page-section title="Firebase Notif">
      <n-button @click="notifyFirebase()">
        Show Notification
      </n-button>
    </page-section>
  </div>
</template>
