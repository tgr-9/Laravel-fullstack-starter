<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface ResetPasswordForm extends Record<string, unknown> {
  email: string
  password: string
  confirm_password: string
}

const model = useForm<ResetPasswordForm>({
  email: '',
  password: '',
  confirm_password: '',
})

const validation = reactiveComputed<{ [k in keyof Partial<ResetPasswordForm>]: 'error' | undefined }>(() => ({
  email: model.errors.email !== undefined ? 'error' : undefined,
  password: model.errors.password !== undefined ? 'error' : undefined,
  confirm_password: model.errors.confirm_password !== undefined ? 'error' : undefined,
}))

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
    <n-form-item
      path="email"
      :label="$t('auth.email.label')"
      :feedback="model.errors.email"
      :validation-status="validation.email"
      :label-props="{ for: 'username' }"
    >
      <n-input
        v-model:value="model.email"
        :input-props="{ id: 'email', name: 'email', type: 'email', autocomplete: 'email' }"
        :placeholder="$t('auth.email.placeholder')"
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
      :label-props="{ for: 'username' }"
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

    <n-form-item
      path="confirm_password"
      :label="$t('auth.confirm_password.label')"
      :feedback="model.errors.confirm_password"
      :validation-status="validation.confirm_password"
      :label-props="{ for: 'username' }"
    >
      <n-input
        v-model:value="model.confirm_password"
        show-password-on="mousedown"
        type="password"
        :input-props="{ id: 'confirm_password', name: 'confirm_password' }"
        :placeholder="$t('auth.confirm_password.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
      />
    </n-form-item>

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
