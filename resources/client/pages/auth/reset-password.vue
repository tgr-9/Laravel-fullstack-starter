<script setup lang="ts">
import { Head as iHead, useForm } from '@inertiajs/vue3'
import Layout from '~/layouts/guest-layout.vue'

defineOptions({
  layout: Layout,
})

const { errors: _ } = defineProps<{
  errors: Object
}>()

// const form = ref<FormInst | null>()

const values = useForm({
  email: '',
  password: '',
  confirm_password: '',
})

function submit() {
  values.post(route('password.update'), {
    onFinish: () => values.reset('password', 'confirm_password'),
  })
}
</script>

<template>
  <i-head :title="$t('auth.routes.reset-password')" />

  <n-card :title="$t('auth.routes.reset-password')" size="medium" style="width: 450px; border-radius: 10px">
    <div class="mb-4 text-sm text-gray-600">
      {{ $t('auth.notices.forgot-password') }}
    </div>

    <n-form :model="values" class="form-login" @submit.prevent="submit">
      <n-form-item :label="$t('auth.email.label')" path="email">
        <n-input
          v-model:value="values.email"
          :placeholder="$t('auth.email.placeholder')"
          :loading="values.processing"
          :disabled="values.processing"
          :autofocus="true"
          style="padding: 3px 10px; border-radius: 5px"
        />
      </n-form-item>

      <n-form-item :label="$t('auth.password.label')" path="password">
        <n-input
          v-model:value="values.password"
          :placeholder="$t('auth.password.placeholder')"
          :loading="values.processing"
          :disabled="values.processing"
          type="password"
          style="padding: 3px 10px; border-radius: 5px;"
        />

        <n-input
          v-model:value="values.confirm_password"
          :placeholder="$t('auth.confirm_password.placeholder')"
          :loading="values.processing"
          :disabled="values.processing"
          type="password"
          style="padding: 3px 10px; border-radius: 5px;"
        />
      </n-form-item>

      <n-form-item class="form-button">
        <n-button
          type="primary"
          attr-type="submit"
          :disabled="values.processing"
          :loading="values.processing"
          style="width: 100%;"
          @click="submit"
        >
          {{ $t('auth.actions.reset') }}
        </n-button>
      </n-form-item>
    </n-form>
  </n-card>
</template>
