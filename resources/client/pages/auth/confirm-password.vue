<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface ConfirmPasswordForm {
  password: string
}

const model = useForm<ConfirmPasswordForm>({
  password: '',
})

function submit() {
  model.post(route('password.confirm'), {
    onFinish: () => model.reset('password'),
  })
}
</script>

<template>
  <n-alert type="info">
    {{ $t('auth.notices.confirm-password') }}
  </n-alert>

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <form-input
      path="password" type="password"
      :label="$t('auth.password.label')"
      :placeholder="$t('auth.password.placeholder')"
      :model="model"
      :autofocus="true"
    />

    <n-button
      attr-type="submit"
      class="w-full"
      type="primary"
      :disabled="model.processing"
      :loading="model.processing"
    >
      {{ $t('auth.actions.confirm') }}
    </n-button>
  </n-form>
</template>
