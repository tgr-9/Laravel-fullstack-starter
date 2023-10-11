<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface LoginForm extends Record<string, unknown> {
  username: string
  password: string
  remember: boolean
}

const model = useForm<LoginForm>({
  username: '',
  password: '',
  remember: false,
})

const validation = reactiveComputed<{ [k in keyof Partial<LoginForm>]: 'error' | undefined }>(() => ({
  username: model.errors.username !== undefined ? 'error' : undefined,
  password: model.errors.password !== undefined ? 'error' : undefined,
}))

function submit() {
  model.post(route('login'), {
    onFinish: () => model.reset('password'),
  })
}
</script>

<template>
  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      path="username"
      :label="$t('auth.username.label')"
      :feedback="model.errors.username"
      :validation-status="validation.username"
      :label-props="{ for: 'username' }"
    >
      <n-input
        v-model:value="model.username"
        :input-props="{ id: 'username', name: 'username', autocomplete: 'username' }"
        :placeholder="$t('auth.username.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        :autofocus="true"
      />
    </n-form-item>

    <n-form-item
      path="password"
      :label="$t('auth.password.label')"
      :feedback="model.errors.password"
      :validation-status="validation.password"
      :label-props="{ for: 'password' }"
    >
      <n-input
        v-model:value="model.password"
        show-password-on="mousedown"
        type="password"
        :input-props="{ id: 'password', name: 'password' }"
        :placeholder="$t('auth.password.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
      />
    </n-form-item>

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
