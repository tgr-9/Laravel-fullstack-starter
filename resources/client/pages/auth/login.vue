<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  pageName: 'auth.routes.login',
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
      :label="$t('auth.username.label')"
      :feedback="model.errors.username"
      :validation-status="validation.username"
      path="username"
    >
      <n-input
        id="username"
        v-model:value="model.username"
        :placeholder="$t('auth.username.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        :autofocus="true"
      />
    </n-form-item>

    <n-form-item
      :label="$t('auth.password.label')"
      :feedback="model.errors.password"
      :validation-status="validation.password"
      path="password"
    >
      <n-input
        id="password"
        v-model:value="model.password"
        :placeholder="$t('auth.password.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        show-password-on="mousedown"
        type="password"
      />
    </n-form-item>

    <n-checkbox v-model:checked="model.remember" :label="$t('auth.remember.label')" />

    <n-button
      type="primary"
      attr-type="submit"
      :disabled="model.processing"
      :loading="model.processing"
      style="width: 100%;"
      @click="submit"
    >
      {{ $t('auth.actions.login') }}
    </n-button>
  </n-form>

  <i-link :href="$route('password.request')">
    {{ $t('auth.actions.forgot') }}
  </i-link>
</template>
