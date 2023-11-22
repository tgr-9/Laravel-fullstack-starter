<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface ResetPasswordForm {
  email: string
  password: string
  confirm_password: string
}

const model = useForm<ResetPasswordForm>({
  email: '',
  password: '',
  confirm_password: '',
})

function submit() {
  model.post(route('password.update'), {
    onFinish: () => model.reset('password', 'confirm_password'),
  })
}
</script>

<template>
  <n-alert :title="$t('auth.routes.reset-password')" type="info">
    {{ $t('auth.notices.forgot-password') }}
  </n-alert>

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <form-input
      path="email"
      :label="$t('auth.email.label')"
      :placeholder="$t('auth.email.placeholder')"
      :model="model"
      :autofocus="true"
    />

    <form-input
      path="password" type="password"
      :label="$t('auth.password.label')"
      :placeholder="$t('auth.password.placeholder')"
      :input-props="{ autocomplete: 'current-password' }"
      :model="model"
    />

    <form-input
      path="confirm_password" type="password"
      :label="$t('auth.confirm_password.label')"
      :placeholder="$t('auth.confirm_password.placeholder')"
      :input-props="{ autocomplete: 'confirm-password' }"
      :model="model"
    />

    <n-button
      attr-type="submit"
      class="w-full"
      type="primary"
      :disabled="model.processing"
      :loading="model.processing"
    >
      {{ $t('auth.actions.reset') }}
    </n-button>
  </n-form>
</template>
