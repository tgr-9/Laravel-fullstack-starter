<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface LoginForm {
  username: string
  password: string
  remember: boolean
  device?: string
}

const model = useForm<LoginForm>({
  username: '',
  password: '',
  remember: false,
  device: appPreference.value.deviceToken,
})

function submit() {
  model.post(route('login'), {
    onFinish: () => model.reset('password'),
  })
}
</script>

<template>
  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <form-input
      path="username"
      :label="$t('auth.username.label')"
      :placeholder="$t('auth.username.placeholder')"
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

    <n-checkbox v-model:checked="model.remember" :label="$t('auth.remember.label')" />

    <n-button
      attr-type="submit"
      class="w-full"
      type="primary"
      :disabled="model.processing"
      :loading="model.processing"
    >
      {{ $t('auth.actions.login') }}
    </n-button>
  </n-form>

  <i-link :href="$route('password.request')">
    {{ $t('auth.actions.forgot') }}
  </i-link>
</template>
