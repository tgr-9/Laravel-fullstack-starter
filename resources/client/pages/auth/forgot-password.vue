<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface ForgotPasswordForm {
  email: string
}

const model = useForm<ForgotPasswordForm>({
  email: '',
})

function submit() {
  model.post(route('password.email'), {
    onFinish: () => model.reset('email'),
  })
}
</script>

<template>
  <n-alert :title="$t('auth.routes.forgot-password')" type="info">
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

    <n-button
      attr-type="submit"
      class="w-full"
      type="primary"
      :disabled="model.processing"
      :loading="model.processing"
    >
      {{ $t('auth.actions.request') }}
    </n-button>
  </n-form>

  <i-link :href="$route('login')">
    {{ $t('auth.actions.login') }}
  </i-link>
</template>
