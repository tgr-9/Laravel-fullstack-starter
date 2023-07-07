<script setup lang="ts">
import { Head as iHead, Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface RegisterForm extends Record<string, unknown> {
  email: string
  password: string
  confirm_password: string
}

const model = useForm<RegisterForm>({
  email: '',
  password: '',
  confirm_password: '',
})

const validation = reactiveComputed<{ [k in keyof Partial<RegisterForm>]: 'error' | undefined }>(() => ({
  email: model.errors.email !== undefined ? 'error' : undefined,
  password: model.errors.password !== undefined ? 'error' : undefined,
  confirm_password: model.errors.confirm_password !== undefined ? 'error' : undefined,
}))

function submit() {
  model.post(route('register'), {
    onFinish: () => model.reset('password', 'confirm_password'),
  })
}
</script>

<template>
  <i-head :title="$t('auth.routes.register')" />

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      :label="$t('auth.email.label')"
      :feedback="model.errors.email"
      :validation-status="validation.email"
      path="email"
    >
      <n-input
        id="email"
        v-model:value="model.email"
        :placeholder="$t('auth.email.placeholder')"
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

    <n-form-item
      :label="$t('auth.confirm_password.label')"
      :feedback="model.errors.confirm_password"
      :validation-status="validation.confirm_password"
      path="confirm_password"
    >
      <n-input
        id="confirm-password"
        v-model:value="model.confirm_password"
        :placeholder="$t('auth.confirm_password.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        show-password-on="mousedown"
        type="password"
      />
    </n-form-item>

    <n-button
      type="primary"
      attr-type="submit"
      :disabled="model.processing"
      :loading="model.processing"
      style="width: 100%;"
      @click="submit"
    >
      {{ $t('auth.actions.register') }}
    </n-button>
  </n-form>

  <i-link :href="$route('login')">
    {{ $t('auth.actions.registered') }}
  </i-link>
</template>
