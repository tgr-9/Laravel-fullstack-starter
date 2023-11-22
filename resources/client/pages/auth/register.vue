<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface RegisterForm {
  email: string
  password: string
  confirm_password: string
}

const model = useForm<RegisterForm>({
  email: '',
  password: '',
  confirm_password: '',
})

function submit() {
  model.post(route('register'), {
    onFinish: () => model.reset('password', 'confirm_password'),
  })
}
</script>

<template>
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
      :input-props="{ autocomplete: 'new-password' }"
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
      {{ $t('auth.actions.register') }}
    </n-button>
  </n-form>

  <i-link :href="$route('login')">
    {{ $t('auth.actions.registered') }}
  </i-link>
</template>
